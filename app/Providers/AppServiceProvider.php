<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Barryvdh\Debugbar\ServiceProvider as Debugbar;
use Illuminate\Notifications\Channels\DatabaseChannel as IlluminateDatabaseChannel;
use App\Observers\AdvertObserver;
use App\Advert;
use App\Channels\DatabaseChannel;
use Illuminate\Support\Facades\App;

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
        // Overwrite native notifications database channel with a custom one
        // that supports subject columns in notifications table.
        $this->app->instance(IlluminateDatabaseChannel::class, new DatabaseChannel);

        // Register new validation rule.
        \Validator::extend('spamfree', 'App\Rules\SpamFree@passes');

        // Register the observers.
        Advert::observe(AdvertObserver::class);

        // Set the global carbon locale.
        \Carbon\Carbon::setLocale(config('app.locale'));
    }
}
