<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'name' => 'Burger',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
