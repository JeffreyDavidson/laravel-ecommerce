<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Cart extends Model
{
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });

    }

    /**
     * Get the user that owns the Cart
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
