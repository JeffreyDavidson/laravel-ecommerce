<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Cart\Exceptions\QuantityNoLongerAvailable;
use Illuminate\Http\Request;

class CheckoutIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CartInterface $cart)
    {
        try {
            $cart->verifyAvailableQuantities();
        } catch (QuantityNoLongerAvailable) {
            $cart->syncAvailableQuantities();
        }

        return view('checkout');
    }
}
