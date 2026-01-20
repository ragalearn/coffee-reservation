<?php

namespace App\Exports;

use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReservationsExport implements FromView
{
    protected $reservations;

    public function __construct($reservations)
    {
        $this->reservations = $reservations;
    }

    public function view(): View
    {
        return view('admin.reports.excel', [
            'reservations' => $this->reservations
        ]);
    }
}
