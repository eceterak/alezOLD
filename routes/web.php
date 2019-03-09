<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'PagesController@index');

Route::get('/pokoje', 'AdvertsController@index'); // Display all adverts.

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    
    // Adverts actions
    Route::post('/pokoje', 'AdvertsController@store');
    Route::get('/pokoje/edytuj/{advert}', 'AdvertsController@edit'); // Edit advert.

    // Cities actions
    Route::get('/miasta/dodaj', 'CitiesController@create');
    Route::post('/miasta', 'CitiesController@store');
    Route::get('/{city}/edytuj', 'CitiesController@edit');
});

Route::get('/miasta', 'CitiesController@index');
Route::get('/{city}', 'CitiesController@show');
Route::get('/pokoje/dodaj', 'AdvertsController@create');
Route::get('/pokoje/{advert}', 'AdvertsController@show'); // Display a single advert.
