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
        [$firstProductId, $secondProductId] = DB::table('products')->pluck('id')->toArray();

        DB::table('variations')->insert([
            [
                'product_id' => $firstProductId,
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
                'product_id' => $firstProductId,
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
                'product_id' => $firstProductId,
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
                'product_id' => $firstProductId,
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
                'product_id' => $firstProductId,
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
                'product_id' => $firstProductId,
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

        $blueNikeProductId = DB::table('variations')->insertGetId([
            'product_id' => $secondProductId,
            'title' => 'Blue',
            'price' => 9000,
            'type' => 'color',
            'sku' => null,
            'parent_id' => null,
            'order' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('variations')->insert([
            [
                'product_id' => $secondProductId,
                'title' => '12',
                'price' => 9000,
                'type' => 'size',
                'sku' => fake()->randomNumber(8, true),
                'parent_id' => $blueNikeProductId,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
