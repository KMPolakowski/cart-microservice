<?php

namespace App\Providers;

use App\Handlers\AddHandler;
use App\Handlers\CartChangeHandlerInterface;
use App\Handlers\CheckoutHandler;
use App\Handlers\RemoveHandler;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartChangeHandlerInterface::class, function ($app) {
            return new AddHandler(
                new RemoveHandler(
                    new CheckoutHandler()
                )
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [
            CartChangeHandlerInterface::class
        ];
    }
}
