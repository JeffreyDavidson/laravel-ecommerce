<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variationIds = DB::table('variations')->get()->pluck('id');

        foreach ($variationIds as $variationId) {
            DB::table('stocks')->insert([
                'variation_id' => $variationId,
                'amount' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
