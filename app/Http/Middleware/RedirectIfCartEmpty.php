<?php

namespace App\Http\Middleware;

use App\Cart\Contracts\CartInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfCartEmpty
{
    public function __construct(protected CartInterface $cart) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->cart->isEmpty()) {
            return to_route('cart');
        }

        return $next($request);
    }
}
