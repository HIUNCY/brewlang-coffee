<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        view()->composer('*', function (View $view) {
            $cartService = app(CartService::class);

            $view->with('cartItemCount', $cartService->getItemCount());
        });
    }
}
