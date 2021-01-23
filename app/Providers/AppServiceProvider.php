<?php

namespace App\Providers;

use App\Handlers\CartChangeHandler\AddHandler;
use App\Handlers\CartChangeHandler\CartChangeHandler;
use App\Handlers\CartChangeHandler\ChangeAmountHandler;
use App\Handlers\CartChangeHandler\CheckoutHandler;
use App\Handlers\CartChangeHandler\RemoveHandler;
use App\Models\PaymentDetail;
use App\Models\User;
use App\Service\Interfaces\PaymentDataRegistratorInterface;
use App\Service\Interfaces\UserRegistratorInterface;
use App\Service\PaymentDataRegistrator;
use App\Service\UserRegistrator;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartChangeHandler::class, function ($app) {
            return new AddHandler(
                new ChangeAmountHandler(
                    new CheckoutHandler(
                        new CheckoutHandler(
                            new RemoveHandler()
                        )
                    )
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
            UserRegistratorInterface::class,
            PaymentDataRegistratorInterface::class
        ];
    }
}
