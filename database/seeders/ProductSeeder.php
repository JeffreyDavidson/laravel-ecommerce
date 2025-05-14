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
        $nikeCategoryId = DB::table('categories')->where('slug', 'nike')->value('id');
        $newInCategoryId = DB::table('categories')->where('slug', 'new-in')->value('id');

        $nikeProduct1Id = DB::table('products')->insertGetId([
            'title' => 'Nike Air Force 1',
            'slug' => 'nike-air-force-1',
            'description' => 'Nike Air Force 1 Description',
            'price' => 9000,
            'live_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('category_product')->insert([
            'category_id' => $nikeCategoryId,
            'product_id' => $nikeProduct1Id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('category_product')->insert([
            'category_id' => $newInCategoryId,
            'product_id' => $nikeProduct1Id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $nikeProduct2Id = DB::table('products')->insertGetId([
            'title' => 'Nike Air Force 2',
            'slug' => 'nike-air-force-2',
            'description' => 'Nike Air Force 2 Description',
            'price' => 9000,
            'live_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('category_product')->insert([
            'category_id' => $nikeCategoryId,
            'product_id' => $nikeProduct2Id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
