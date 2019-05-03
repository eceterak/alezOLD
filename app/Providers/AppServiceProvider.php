<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\AdvertObserver;
use Illuminate\Support\Facades\Route;
use App\Room;

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
        Room::observe(AdvertObserver::class);

        Route::resourceVerbs([
            'create' => 'dodaj',
            'edit' => 'edytuj'
        ]);
    }
}
