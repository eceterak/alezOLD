<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Observers\TemporaryAdvertObserver;
use App\Observers\AdvertObserver;
use App\TemporaryAdvert;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TemporaryAdvert::observe(TemporaryAdvertObserver::class);

        Advert::observe(AdvertObserver::class);

        Route::resourceVerbs([
            'create' => 'dodaj',
            'edit' => 'edytuj'
        ]);
    }
}
