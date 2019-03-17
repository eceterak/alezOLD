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

/**
 * --------------------------------------------------------------------------
 * Admin Routes
 * --------------------------------------------------------------------------
 */

Route::get('/admin/login', 'AdminController@login')->middleware('guest')->name('adminLoginPage');

Route::group(['middleware' => 'admin'], function() {
    Route::get('/admin', 'AdminController@index');

    // Cities
    Route::get('/admin/miasta', 'AdminCitiesController@index')->name('cities.index');
    Route::get('/admin/miasta/dodaj', 'AdminCitiesController@create')->name('cities.create');
    Route::post('/admin/miasta', 'AdminCitiesController@store');
    Route::get('/admin/{city}', 'AdminCitiesController@edit');
});

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

Route::get('/pokoje', 'AdvertsController@index'); // Display all adverts.

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    
    // Adverts actions
    Route::post('/pokoje', 'AdvertsController@store');
    Route::get('/pokoje/edytuj/{advert}', 'AdvertsController@edit'); // Edit advert.
});

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

Route::get('/miasta', 'CitiesController@index');
Route::get('/{city}', 'CitiesController@show');
Route::get('/pokoje/dodaj', 'AdvertsController@create');
Route::get('/pokoje/{advert}', 'AdvertsController@show'); // Display a single advert.
