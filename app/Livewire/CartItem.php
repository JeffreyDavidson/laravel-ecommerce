<?php

namespace App\Livewire;

use App\Models\Variation;
use Livewire\Component;

class CartItem extends Component
{
    public Variation $variation;

    public function render()
    {
        return view('livewire.cart-item');
    }
}
