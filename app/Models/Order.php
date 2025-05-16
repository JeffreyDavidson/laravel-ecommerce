<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Order extends Model
{
    public $fillable = [
        'email',
        'subtotal',
        'placed_at',
        'packaged_at',
        'shipped_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'placed_at' => 'timestamp',
            'packaged_at' => 'timestamp',
            'shipped_at' => 'timestamp',
        ];
    }

    public $statuses = [
        'placed_at',
        'packaged_at',
        'shipped_at',
    ];

    public static function booted()
    {
        static::creating(function (Order $order) {
            $order->placed_at = now();
            $order->uuid = (string) Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shippingType(): BelongsTo
    {
        return $this->belongsTo(ShippingType::class);
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function variations(): BelongsToMany
    {
        return $this->belongsToMany(Variation::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function status()
    {
        return collect($this->statuses)
            ->last(fn ($status) => filled($this->{$status}));
    }

    public function formattedSubtotal(): string
    {
        return money($this->subtotal);
    }
}
