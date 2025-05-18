<?php

namespace App\Listeners;

use App\Models\Order;
use Illuminate\Auth\Events\Registered;

class AttachOrders
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        Order::query()
            ->where('email', $event->user->email)
            ->get()
            ->each(function (Order $order) use ($event) {
                $order->user()->associate($event->user);
                $order->shippingAddress->user()->associate($event->user);
                $order->shippingAddress->save();
                $order->save();
            });
    }
}
