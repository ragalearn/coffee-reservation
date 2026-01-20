<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Category; // UBAH: Pakai Category, bukan Table
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user role pelanggan
        $user = User::where('role', 'pelanggan')->first();
        
        // UBAH: Ambil data dari Category, bukan Table
        $category = Category::first();

        // Pastikan data user & category tersedia
        if (!$user || !$category) {
            // Opsional: Bisa kasih info di terminal kalau data kosong
            $this->command->info('User atau Category kosong, skip seeding reservation.');
            return;
        }

        Reservation::create([
            'user_id'          => $user->id,
            
            // UBAH: Gunakan category_id
            'category_id'      => $category->id, 
            
            'reservation_date' => Carbon::now()->addDay()->toDateString(),
            'reservation_time' => '18:00',
            'people_count'     => 2,
            'status'           => 'pending',
        ]);
    }
}