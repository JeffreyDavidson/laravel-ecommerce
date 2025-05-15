<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingAddress extends Model
{
    protected $fillable = [
        'address',
        'city',
        'postcode',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function formattedAddress()
    {
        return sprintf('%s, %s, %s',
            $this->address,
            $this->city,
            $this->postcode,
        );
    }
}
