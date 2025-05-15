<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shipping_types')->insert([
            [
                'title' => 'UPS Free',
                'price' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'UPS Standard',
                'price' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
