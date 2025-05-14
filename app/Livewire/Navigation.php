<?php

namespace App\Livewire;

use App\Cart\Contracts\CartInterface;
use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('cart.updated')]
class Navigation extends Component
{
    public $searchQuery = '';

    public function clearSearch()
    {
        $this->searchQuery = '';
    }

    #[Computed]
    public function cart()
    {
        return app(CartInterface::class);
    }

    public function render()
    {
        $products = Product::search($this->searchQuery)->get();

        return view('livewire.navigation', [
            'products' => $products,
        ]);
    }
}
