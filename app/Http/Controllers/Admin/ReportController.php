<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ReservationsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * ==============================
     * REPORT DASHBOARD
     * ==============================
     */
    public function index(Request $request)
    {
        /*
        |------------------------------------------------------------------
        | DATE RANGE (DEFAULT: 7 HARI TERAKHIR)
        |------------------------------------------------------------------
        */
        $startDate = $request->start_date
            ?? Carbon::now()->subDays(6)->toDateString();

        $endDate = $request->end_date
            ?? Carbon::now()->toDateString();

        /*
        |------------------------------------------------------------------
        | FILTER CATEGORY
        |------------------------------------------------------------------
        */
        $categoryId = $request->category;

        /*
        |------------------------------------------------------------------
        | QUERY RESERVATION
        |------------------------------------------------------------------
        */
        $query = Reservation::with(['user', 'category'])
            ->whereBetween('reservation_date', [$startDate, $endDate]);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $reservations = $query
            ->orderBy('reservation_date')
            ->get();

        /*
        |------------------------------------------------------------------
        | SUMMARY STATUS
        |------------------------------------------------------------------
        */
        $pending   = $reservations->where('status', 'pending')->count();
        $confirmed = $reservations->where('status', 'confirmed')->count();
        $cancelled = $reservations->where('status', 'cancelled')->count();
        $rejected  = $reservations->where('status', 'rejected')->count();

        $totalReservations = $reservations->count();

        /*
        |------------------------------------------------------------------
        | PIE CHART (%)
        |------------------------------------------------------------------
        */
        $totalForPie = $pending + $confirmed + $cancelled + $rejected;

        $percConfirmed = $totalForPie ? round(($confirmed / $totalForPie) * 100) : 0;
        $percPending   = $totalForPie ? round(($pending / $totalForPie) * 100) : 0;
        $percCancelled = $totalForPie
            ? round((($cancelled + $rejected) / $totalForPie) * 100)
            : 0;

        /*
        |------------------------------------------------------------------
        | BAR CHART (HARIAN)
        |------------------------------------------------------------------
        */
        $weeklyData = [];
        $maxHeight = 1;

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $count = $reservations
                ->where('reservation_date', $date->toDateString())
                ->count();

            $weeklyData[] = [
                'day'   => $date->format('d M'),
                'total' => $count,
            ];

            if ($count > $maxHeight) {
                $maxHeight = $count;
            }
        }

        /*
        |------------------------------------------------------------------
        | BAR CHART PER CATEGORY
        |------------------------------------------------------------------
        */
        $categoryChart = Reservation::selectRaw(
                'categories.name as name, COUNT(*) as total'
            )
            ->join('categories', 'reservations.category_id', '=', 'categories.id')
            ->whereBetween('reservation_date', [$startDate, $endDate])
            ->when($categoryId, fn ($q) =>
                $q->where('reservations.category_id', $categoryId)
            )
            ->groupBy('categories.name')
            ->get();

        /*
        |------------------------------------------------------------------
        | CATEGORY LIST
        |------------------------------------------------------------------
        */
        $categories = Category::all();

        /*
        |------------------------------------------------------------------
        | VIEW
        |------------------------------------------------------------------
        */
        return view('admin.reports.index', compact(
            'reservations',
            'categories',
            'categoryId',
            'pending',
            'confirmed',
            'cancelled',
            'rejected',
            'totalReservations',
            'percConfirmed',
            'percPending',
            'percCancelled',
            'weeklyData',
            'maxHeight',
            'categoryChart',
            'startDate',
            'endDate'
        ));
    }

    /**
     * ==============================
     * EXPORT PDF
     * ==============================
     */
    public function exportPdf(Request $request)
    {
        $startDate = $request->start_date
            ?? Carbon::now()->subDays(6)->toDateString();

        $endDate = $request->end_date
            ?? Carbon::now()->toDateString();

        $categoryId = $request->category;

        $query = Reservation::with(['user', 'category'])
            ->whereBetween('reservation_date', [$startDate, $endDate]);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $reservations = $query
            ->orderBy('reservation_date')
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
                'reservations',
                'startDate',
                'endDate'
            ))
            ->setPaper('A4', 'landscape');

        return $pdf->download(
            'reservation-report-' . $startDate . '-to-' . $endDate . '.pdf'
        );
    }

    /**
     * ==============================
     * EXPORT EXCEL
     * ==============================
     */
    public function exportExcel(Request $request)
    {
        $reservations = Reservation::with(['user', 'category'])
            ->orderBy('reservation_date')
            ->get();

        return Excel::download(
            new ReservationsExport($reservations),
            'reservation-report.xlsx'
        );
    }
}
