<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user  = User::where('role', 'pelanggan')->first();
        $table = Table::first();

        // Pastikan data user & table tersedia
        if (!$user || !$table) {
            return;
        }

        Reservation::create([
            'user_id'          => $user->id,
            'table_id'         => $table->id,
            'reservation_date' => Carbon::now()->addDay()->toDateString(),
            'reservation_time' => '18:00',
            'people_count'     => 2,
            'status'           => 'pending',
        ]);
    }
}
