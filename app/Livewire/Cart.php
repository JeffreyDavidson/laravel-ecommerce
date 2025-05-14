<?php

namespace App\Livewire;

use App\Cart\Contracts\CartInterface;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('cart.updated')]
class Cart extends Component
{
    public function render()
    {
        return view('livewire.cart', [
            'cart' => app(CartInterface::class),
        ]);
    }
}
