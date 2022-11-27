<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        DB::table('product_ingredients')->insert([
            'product_id' => 1,
            'ingredient_id' => 1,
            'quantity' => 150 //150 grams beef
        ]);

        DB::table('product_ingredients')->insert([
            'product_id' => 1,
            'ingredient_id' => 2,
            'quantity' => 30 //30 grams cheese
        ]);

        DB::table('product_ingredients')->insert([
            'product_id' => 1,
            'ingredient_id' => 3,
            'quantity' => 20 //20 grams onion
        ]);
    }
}
