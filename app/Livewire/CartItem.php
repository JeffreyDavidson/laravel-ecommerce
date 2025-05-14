<?php

namespace App\Livewire;

use App\Cart\Contracts\CartInterface;
use App\Models\Variation;
use Livewire\Component;

class CartItem extends Component
{
    public Variation $variation;

    public $quantity;

    public function mount()
    {
        $this->quantity = $this->variation->pivot->quantity;
    }

    public function updatedQuantity(int $quantity)
    {
        app(CartInterface::class)->changeQuantity($this->variation, $quantity);

        $this->dispatch('cart.updated');

        $this->dispatch('notification',
            body: 'Quantity updated',
        );
    }

    public function render()
    {
        return view('livewire.cart-item');
    }
}
