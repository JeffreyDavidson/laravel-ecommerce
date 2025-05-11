<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productId = DB::table('products')->take(1)->get()->value('id');

        DB::table('variations')->insert([
            [
                'product_id' => $productId,
                'title' => 'Black',
                'price' => 9000,
                'type' => 'color',
                'sku' => null,
                'parent_id' => null,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId,
                'title' => 'White',
                'price' => 9000,
                'type' => 'color',
                'sku' => null,
                'parent_id' => null,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId,
                'title' => '8',
                'price' => 9000,
                'type' => 'size',
                'sku' => fake()->randomNumber(8, true),
                'parent_id' => 1,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId,
                'title' => '9',
                'price' => 9000,
                'type' => 'size',
                'sku' => fake()->randomNumber(8, true),
                'parent_id' => 1,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId,
                'title' => '8',
                'price' => 9000,
                'type' => 'size',
                'sku' => fake()->randomNumber(8, true),
                'parent_id' => 2,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId,
                'title' => '9',
                'price' => 9000,
                'type' => 'size',
                'sku' => fake()->randomNumber(8, true),
                'parent_id' => 2,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
