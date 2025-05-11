<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    public function formattedPrice(): string
    {
        return money($this->price);
    }

    /**
     * Get all of the comments for the Product
     */
    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class);
    }
}
