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

    public function updated()
    {
        dd('updated hook');
    }

    public function render()
    {
        return view('livewire.product-dropdown');
    }
}
