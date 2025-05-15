<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingType extends Model
{
    public function formattedPrice(): string
    {
        return money($this->price);
    }
}
