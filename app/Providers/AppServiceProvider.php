<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

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
        Gate::define('manage-products', function ($user) {
           return $user->isAdmin();
        });

        View::composer('*', function ($view) {
            $cartItemCount = 0;

            if (Auth::check()) {
                $cartItemCount = CartItem::whereHas('cart', function ($query) {
                    $query->where('user_id', Auth::id());
                })->count();
            }

            $view->with('cartItemCount', $cartItemCount);
        });
    }
}
