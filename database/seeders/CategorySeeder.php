<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Kita isi 3 Kategori Utama
        // ID otomatis akan jadi 1, 2, 3
        DB::table('categories')->insert([
            [
                'name' => 'Outdoor',
                'description' => 'Suasana segar dengan pemandangan alam.',
                'image' => 'assets/img/v446_329.png', // Sesuaikan path gambarmu
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Indoor Area',
                'description' => 'Nyaman dan sejuk ber-AC.',
                'image' => 'assets/img/v446_295.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Semi Outdoor',
                'description' => 'Perpaduan sejuknya angin luar dan atap peneduh.',
                'image' => 'assets/img/v446_316.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}