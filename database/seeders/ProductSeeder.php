<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'title' => 'Example Product',
            'slug' => 'example-product',
            'description' => 'This is an example product.',
            'price' => 5000,
            'live_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
