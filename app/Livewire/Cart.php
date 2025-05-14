<?php

namespace App\Livewire;

use App\Cart\Contracts\CartInterface;
use Livewire\Component;

class Cart extends Component
{
    public function render()
    {
        return view('livewire.cart', [
            'cart' => app(CartInterface::class),
        ]);
    }
}
