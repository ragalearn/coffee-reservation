<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;
use App\Models\Category;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indoor  = Category::where('name', 'Indoor')->first();
        $outdoor = Category::where('name', 'Outdoor')->first();
        $vip     = Category::where('name', 'VIP')->first();

        // Indoor tables (5 meja, kapasitas 4)
        for ($i = 1; $i <= 5; $i++) {
            Table::create([
                'table_number' => 'I-' . $i,
                'capacity'     => 4,
                'category_id'  => $indoor->id,
                'status'       => 'available',
            ]);
        }

        // Outdoor tables (3 meja, kapasitas 4)
        for ($i = 1; $i <= 3; $i++) {
            Table::create([
                'table_number' => 'O-' . $i,
                'capacity'     => 4,
                'category_id'  => $outdoor->id,
                'status'       => 'available',
            ]);
        }

        // VIP tables (2 meja, kapasitas 8)
        for ($i = 1; $i <= 2; $i++) {
            Table::create([
                'table_number' => 'V-' . $i,
                'capacity'     => 8,
                'category_id'  => $vip->id,
                'status'       => 'available',
            ]);
        }
    }
}
