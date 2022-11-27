<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        DB::table('ingredients')->insert([
            'name' => 'Beef',
            'total_amount' => 20000,
            'amount_consumed' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ingredients')->insert([
            'name' => 'Cheese',
            'total_amount' => 5000,
            'amount_consumed' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('ingredients')->insert([
            'name' => 'Onion',
            'total_amount' => 1000,
            'amount_consumed' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
