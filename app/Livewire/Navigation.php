<?php

namespace App\Livewire;

use App\Cart\Contracts\CartInterface;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('cart.updated')]
class Navigation extends Component
{
    #[Computed]
    public function cart()
    {
        return app(CartInterface::class);
    }

    public function render()
    {
        return view('livewire.navigation');
    }
}
