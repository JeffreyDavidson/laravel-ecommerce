<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductShowController extends Controller
{
    public function __invoke(Product $product)
    {
        $product->load('variations.children', 'variations.descendantsAndSelf.stocks');

        return view('products.show', [
            'product' => $product,
        ]);
    }
}
