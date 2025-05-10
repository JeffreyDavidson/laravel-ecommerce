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
            'title' => 'Nike Air Force 1',
            'slug' => 'nike-air-force-1',
            'description' => 'Nike Air Force 1 Description',
            'price' => 9000,
            'live_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
