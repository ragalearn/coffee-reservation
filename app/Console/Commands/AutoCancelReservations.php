<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;

class AutoCancelReservations extends Command
{
    protected $signature = 'reservations:auto-cancel';
    protected $description = 'Auto cancel reservations that are late more than 15 minutes';

    public function handle()
    {
        $now = Carbon::now();

        Reservation::whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->each(function ($reservation) use ($now) {

                $reservationTime = Carbon::parse(
                    $reservation->reservation_date . ' ' . $reservation->reservation_time
                );

                // ⏰ TELAT 15 MENIT
                if ($now->diffInMinutes($reservationTime, false) <= -15) {
                    $reservation->update([
                        'status' => 'cancelled'
                    ]);
                }
            });

        $this->info('Late reservations auto-cancelled.');
    }
}
