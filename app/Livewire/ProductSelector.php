<?php

namespace App\Livewire;

use App\Cart\Contracts\CartInterface;
use App\Models\Variation;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductSelector extends Component
{
    public $product;

    public $initialVariation;

    public $skuVariant;

    public function mount()
    {
        $this->initialVariation = $this->product->variations->sortBy('order')->groupBy('type')->first();
    }

    #[On('skuVariantSelected')]
    public function skuVariantSelected($variantId)
    {
        if (! $variantId) {
            $this->skuVariant = null;

            return;
        }

        $this->skuVariant = Variation::find($variantId);
    }

    public function addToCart()
    {
        $cart = app(CartInterface::class);

        $cart->add($this->skuVariant);

        $this->dispatch('cart.updated');

        $this->dispatch('notification', [
            'body' => 'Added to cart',
            'timeout' => 4000,
        ]);
    }

    public function render()
    {
        return view('livewire.product-selector');
    }
}
