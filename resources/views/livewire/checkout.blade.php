<form x-on:submit.prevent="submit" x-data="{
    stripe: null,
    cardElement: null,
    email: @entangle('checkoutForm.email').defer,
    async submit() {
        await $wire.callValidate();

        let errorCount = await $wire.getErrorCount();

        if (errorCount >= 1) {
            return;
        }

        const { paymentIntent, error } = await this.stripe.confirmCardPayment(
            '{{ $paymentIntent->client_secret }}', {
                payment_method: {
                    card: this.cardElement,
                    billing_details: {
                        email: this.email,
                    }
                }
            }
        );

        if (error) {
            window.dispatchEvent(new CustomEvent('notification', {
                detail: {
                    body: error.message,
                    timeout: 10000
                }
            }))
        } else {
            $wire.checkout();
        }
    },
    init() {
        this.stripe = Stripe('{{ config('stripe.key') }}')

        const elements = this.stripe.elements();
        this.cardElement = elements.create('card');

        this.cardElement.mount('#card-element');
    }
}">
    <div class="overflow-hidden sm:rounded-lg grid grid-cols-6 grid-flow-col gap-4">
        <div class="p-6 bg-white border-b border-gray-200 col-span-3 self-start space-y-6">
            @guest
                <div class="space-y-3">
                    <div class="font-semibold text-lg">Account details</div>

                    <div>
                        <label for="email">Email</label>
                        <x-input id="email" class="block mt-1 w-full" type="text" name="email"
                            wire:model.defer="checkoutForm.email" />

                        @error('checkoutForm.email')
                            <div class="mt-2 font-semibold text-red-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            @endguest

            <div class="space-y-3">
                <div class="font-semibold text-lg">Shipping</div>

                @if ($this->userShippingAddresses)
                    <x-select class="w-full" wire:model.live="userShippingAddressId">
                        <option value="">Choose a pre-saved address</option>
                        @foreach ($this->userShippingAddresses as $address)
                            <option value="{{ $address->id }}">{{ $address->formattedAddress() }}</option>
                        @endforeach
                    </x-select>
                @endif

                <div class="space-y-3">
                    <div>
                        <label for="address">Address</label>
                        <x-input id="address" class="block mt-1 w-full" type="text" name="address"
                            wire:model.defer="checkoutForm.address" />

                        @error('checkoutForm.address')
                            <div class="mt-2 font-semibold text-red-500">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label for="city">City</label>
                            <x-input id="city" class="block mt-1 w-full" type="text" name="city"
                                wire:model.defer="checkoutForm.city" />

                            @error('checkoutForm.city')
                                <div class="mt-2 font-semibold text-red-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="postcode">Postal code</label>
                            <x-input id="postcode" class="block mt-1 w-full" type="text"
                                wire:model.defer="checkoutForm.postcode" />

                            @error('checkoutForm.postcode')
                                <div class="mt-2 font-semibold text-red-500">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <div class="font-semibold text-lg">Delivery</div>

                <div class="space-y-1">
                    <x-select class="w-full" wire:model.live="shippingTypeId">
                        @foreach ($shippingTypes as $shippingType)
                            <option value="{{ $shippingType->id }}" wire:key="{{ $shippingType->id }}">
                                {{ $shippingType->title }}
                                ({{ $shippingType->formattedPrice() }})
                            </option>
                        @endforeach
                    </x-select>
                    @error('shippingTypeId')
                        <div class="mt-2 font-semibold text-red-500">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="space-y-3">
                <div class="font-semibold text-lg">Payment</div>

                <div>
                    <div wire:ignore id="card-element"></div>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border-b border-gray-200 col-span-3 self-start space-y-4">
            <div>
                @foreach ($cart->contents() as $variation)
                    <div class="border-b py-3 flex items-start">
                        <div class="w-16 mr-4">
                            <img src="{{ $variation->getFirstMediaUrl('default', 'thumb200x200') }}" class="w-16">
                        </div>

                        <div class="space-y-2">
                            <div>
                                <div class="font-semibold">
                                    {{ $variation->formattedPrice() }}
                                </div>
                                <div class="space-y-1">
                                    <div>{{ $variation->product->title }}</div>

                                    <div class="flex items-center text-sm">
                                        <div class="mr-1 font-semibold">
                                            Quantity: {{ $variation->pivot->quantity }} <span
                                                class="text-gray-400 mx-1">/</span>
                                        </div>
                                        @foreach ($variation->ancestorsAndSelf as $ancestor)
                                            {{ $ancestor->title }} @if (!$loop->last)
                                                <span class="text-gray-400 mx-1">/</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="space-y-4">
                <div class="space-y-1">
                    <div class="space-y-1 flex items-center justify-between">
                        <div class="font-semibold">Subtotal</div>
                        <h1 class="font-semibold">{{ $cart->formattedSubtotal() }}</h1>
                    </div>

                    <div class="space-y-1 flex items-center justify-between">
                        <div class="font-semibold">Shipping ({{ $this->shippingType->title }})</div>
                        <h1 class="font-semibold">{{ $this->shippingType->formattedPrice() }}</h1>
                    </div>

                    <div class="space-y-1 flex items-center justify-between">
                        <div class="font-semibold">Total</div>
                        <h1 class="font-semibold">{{ money($this->total) }}</h1>
                    </div>
                </div>

                <x-button type="submit">Confirm order and pay</x-button>
            </div>
        </div>
    </div>
</form>
