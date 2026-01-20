<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Dasar
        $pending   = Reservation::where('status', 'pending')->count();
        $confirmed = Reservation::where('status', 'confirmed')->count();
        $rejected  = Reservation::where('status', 'rejected')->count();
        $cancelled = Reservation::where('status', 'cancelled')->count();

        // Gabungan Rejected & Cancelled untuk Pie Chart & Kartu Merah
        $totalRejected = $rejected + $cancelled;

        // 2. Hitung Persentase untuk Pie Chart
        $totalForPie = $pending + $confirmed + $totalRejected;
        
        $percConfirmed = $totalForPie > 0 ? round(($confirmed / $totalForPie) * 100) : 0;
        $percPending   = $totalForPie > 0 ? round(($pending / $totalForPie) * 100) : 0;
        $percRejected  = $totalForPie > 0 ? round(($totalRejected / $totalForPie) * 100) : 0;

        // 3. Hitung Data Grafik Mingguan (Bar Chart: Indoor vs Outdoor)
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek   = Carbon::now()->endOfWeek();
        
        $weeklyData = [];
        $maxHeight  = 1; 

        for ($date = $startOfWeek->copy(); $date->lte($endOfWeek); $date->addDay()) {
            $dayDate = $date->format('Y-m-d');

            // Hitung Reservasi Indoor Hari Ini
            $indoorCount = Reservation::whereDate('reservation_date', $dayDate)
                ->whereHas('category', function($q) { 
                    $q->where('name', 'like', '%Indoor%'); 
                })->count();

            // Hitung Reservasi Outdoor Hari Ini
            $outdoorCount = Reservation::whereDate('reservation_date', $dayDate)
                ->whereHas('category', function($q) { 
                    $q->where('name', 'like', '%Outdoor%'); 
                })->count();

            $weeklyData[] = [
                'day'     => $date->format('D'), 
                'indoor'  => $indoorCount,
                'outdoor' => $outdoorCount
            ];

            if ($indoorCount > $maxHeight) $maxHeight = $indoorCount;
            if ($outdoorCount > $maxHeight) $maxHeight = $outdoorCount;
        }

        // 4. Susun Data Akhir (SUDAH DIPERBAIKI)
        $data = [
            'totalUsers'        => User::count(),
            'totalReservations' => Reservation::count(),
            'todayReservations' => Reservation::whereDate('reservation_date', Carbon::today())->count(),

            'pending'   => $pending,
            'confirmed' => $confirmed,
            'rejected'  => $rejected,
            'cancelled' => $cancelled,

            // --- INI PERBAIKANNYA (Variabel yang dicari View) ---
            'rejected_combined' => $totalRejected, 
            // ----------------------------------------------------

            'percConfirmed' => $percConfirmed,
            'percPending'   => $percPending,
            'percRejected'  => $percRejected,
            'weeklyData'    => $weeklyData,
            'maxHeight'     => $maxHeight
        ];

        return view('admin.dashboard', $data);
    }
}