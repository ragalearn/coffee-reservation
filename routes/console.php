<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// =====================================================
// 🔥 AUTO CANCEL RESERVATION (TELAT 15 MENIT)
// =====================================================
Schedule::command('reservations:auto-cancel')->everyMinute();
