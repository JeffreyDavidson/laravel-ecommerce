<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandsId = DB::table('categories')->insertGetId(['title' => 'Brands', 'slug' => 'brands', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()]);
        $seasonsId = DB::table('categories')->insertGetId(['title' => 'Seasons', 'slug' => 'seasons', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()]);
        $nikeId = DB::table('categories')->insertGetId(['title' => 'Nike', 'slug' => 'nike', 'parent_id' => $brandsId, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('categories')->insert(['title' => 'Summer', 'slug' => 'summer', 'parent_id' => $seasonsId, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('categories')->insert(['title' => 'Winter', 'slug' => 'winter', 'parent_id' => $seasonsId, 'created_at' => now(), 'updated_at' => now()]);
        DB::table('categories')->insert(['title' => 'New in', 'slug' => 'new-in', 'parent_id' => $nikeId, 'created_at' => now(), 'updated_at' => now()]);
    }
}
