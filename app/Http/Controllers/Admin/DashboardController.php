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
        $data = [
            'totalUsers'        => User::count(),
            'totalReservations'=> Reservation::count(),
            'todayReservations'=> Reservation::whereDate(
                'reservation_date',
                Carbon::today()
            )->count(),

            'pending'   => Reservation::where('status', 'pending')->count(),
            'confirmed' => Reservation::where('status', 'confirmed')->count(),
            'rejected'  => Reservation::where('status', 'rejected')->count(),
            'cancelled'=> Reservation::where('status', 'cancelled')->count(),
        ];

        return view('admin.dashboard', $data);
    }
}
