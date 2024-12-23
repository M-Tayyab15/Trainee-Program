<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\CartProduct;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Share the cart count with all views
        View::composer('*', function ($view) {
            $cartCount = 0;
            if (Auth::check()) {
                $user = Auth::user();
                $cart = CartProduct::whereHas('cart', function ($query) use ($user) {
                    $query->where('user_id', $user->id)->whereIn('status', [1,2]); // active cart
                })->count();
                $cartCount = $cart;
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
