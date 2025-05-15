<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;

class CheckoutForm extends Form
{
    public $email = '';

    public $address = '';

    public $city = '';

    public $postcode = '';

    public $shippingTypeId = '';

    protected function rules()
    {
        return [
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore(auth()->user() ? auth()->user()->id : '')],
            'address' => ['required', 'max:255'],
            'city' => ['required', 'max:255'],
            'postcode' => ['required', 'max:255'],
            'shippingTypeId' => ['required', Rule::exists('shipping_types', 'id')],
        ];
    }

    protected function messages()
    {
        return [
            'email.unique' => 'Seems you already have an account. Please sign in to place and order.',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'email' => 'email address',
            'address' => 'shipping address',
            'city' => 'shipping city',
            'postcode' => 'shipping postal code',
        ];
    }
}
