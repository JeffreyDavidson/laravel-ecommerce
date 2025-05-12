<?php

namespace App\Livewire;

use App\Models\Variation;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ProductDropdown extends Component
{
    public $variations;

    public $selectedVariation;

    #[Computed]
    public function selectedVariationModel()
    {
        if (! $this->selectedVariation) {
            return;
        }

        return Variation::find($this->selectedVariation);
    }

    public function updatedSelectedVariation()
    {
        $this->dispatch('skuVariantSelected', null);

        if ($this->selectedVariationModel?->sku) {
            $this->dispatch('skuVariantSelected', $this->selectedVariation);
        }
    }

    public function render()
    {
        return view('livewire.product-dropdown');
    }
}
