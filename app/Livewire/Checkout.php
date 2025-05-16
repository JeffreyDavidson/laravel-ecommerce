<?php

namespace App\Livewire;

use App\Cart\Contracts\CartInterface;
use App\Livewire\Forms\CheckoutForm;
use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\ShippingType;
use App\Models\Variation;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Checkout extends Component
{
    public $shippingTypes;

    public $shippingTypeId;

    protected $shippingAddress;

    public $userShippingAddressId;

    public CheckoutForm $checkoutForm;

    public function mount()
    {
        $this->shippingTypes = ShippingType::orderBy('price', 'asc')->get();
        $this->shippingTypeId = $this->checkoutForm->shippingTypeId = $this->shippingTypes->first()->id;

        if ($user = auth()->user()) {
            $this->checkoutForm->email = $user->email;
        }
    }

    public function updatedUserShippingAddressId(int $id)
    {
        if (! $id) {
            return;
        }

        $userShippingAddress = $this->userShippingAddresses->find($id)->only('address', 'city', 'postcode');

        $this->checkoutForm->address = $userShippingAddress['address'];
        $this->checkoutForm->city = $userShippingAddress['city'];
        $this->checkoutForm->postcode = $userShippingAddress['postcode'];
    }

    #[Computed]
    public function userShippingAddresses()
    {
        return auth()->user()?->shippingAddresses;
    }

    #[Computed]
    public function shippingType()
    {
        return $this->shippingTypes->find($this->shippingTypeId);
    }

    public function updatedShippingTypeId(int $id)
    {
        if (! $id) {
            return;
        }

        $this->checkoutForm->shippingTypeId = $id;
    }

    #[Computed]
    public function total()
    {
        $cart = app(CartInterface::class);

        return $cart->subtotal() + $this->shippingType->price;
    }

    public function checkout(CartInterface $cart)
    {
        $this->validate();

        $this->shippingAddress = ShippingAddress::query()
            ->when(auth()->user(), function ($query) {
                $query->whereBelongsTo(auth()->user());
            })
            ->firstOrCreate([
                'address' => $this->checkoutForm->address,
                'city' => $this->checkoutForm->city,
                'postcode' => $this->checkoutForm->postcode,
            ])?->user()
            ->associate(auth()->user())
            ->save();

        $order = Order::make([
            'email' => $this->checkoutForm->email,
            'subtotal' => $cart->subtotal(),
        ]);

        $order->user()->associate(auth()->user());
        $order->shippingType()->associate($this->shippingType);
        $order->shippingAddress()->associate($this->shippingAddress);

        $order->save();

        $order->variations()->attach(
            $cart->contents()->mapWithKeys(function ($variation) {
                return [
                    $variation->id => [
                        'quantity' => $variation->pivot->quantity,
                    ],
                ];
            })
                ->toArray()
        );

        $cart->contents()->each(function (Variation $variation) {
            $variation->stocks()->create([
                'amount' => 0 - $variation->pivot->quantity,
            ]);
        });

        $cart->removeAll();

        Mail::to($order->email)->send(new OrderCreated($order));

        $cart->destroy();

        if (auth()->user()) {
            return to_route('orders.confirmation', $order);
        }

        return to_route('orders');
    }

    public function getPaymentIntent(CartInterface $cart)
    {
        if ($cart->hasPaymentIntent()) {
            $paymentIntent = app('stripe')->paymentIntents->retrieve($cart->getPaymentIntentId());

            if ($paymentIntent->status !== 'succeeded') {
                app('stripe')->paymentIntents->update($cart->getPaymentIntentId(), [
                    'amount' => (int) $this->total,
                ]);
            }

            return $paymentIntent;
        }

        $paymentIntent = app('stripe')->paymentIntents->create([
            'amount' => (int) $this->total,
            'currency' => 'usd',
            'setup_future_usage' => 'on_session',
        ]);

        $cart->updatePaymentIntentId($paymentIntent->id);

        return $paymentIntent;
    }

    public function render(CartInterface $cart)
    {
        return view('livewire.checkout', [
            'cart' => $cart,
            'paymentIntent' => $this->getPaymentIntent($cart),
        ]);
    }
}
