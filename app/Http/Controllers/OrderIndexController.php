<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $orders = $request->user()->orders()->latest()
            ->with('variations.product', 'variations.media', 'variations.ancestorsAndSelf', 'shippingType')
            ->get();

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }
}
