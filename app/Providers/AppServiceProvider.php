<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Barryvdh\Debugbar\ServiceProvider as Debugbar;
use App\Observers\AdvertObserver;
use App\Advert;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->isLocal())
        {
            $this->app->register(Debugbar::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');

        Advert::observe(AdvertObserver::class);
    }
}
