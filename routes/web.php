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

Route::get('/admin/login', 'Admin\AdminController@login')->middleware('guest')->name('admin.login');

Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function() {
    Route::get('/admin', 'AdminController@index')->name('admin');
    
    // Cities
    Route::get('/admin/miasta', 'CitiesController@index')->name('admin.cities');
    Route::get('/admin/miasta/dodaj', 'CitiesController@create')->name('admin.cities.create');
    Route::post('/admin/miasta', 'CitiesController@store')->name('admin.cities.store');
    Route::get('/admin/{city}/edytuj', 'CitiesController@edit')->name('admin.cities.edit');
    Route::patch('/admin/{city}/edytuj', 'CitiesController@update')->name('admin.cities.update');
    
    // Rooms
    Route::get('/admin/pokoje', 'RoomsController@index')->name('admin.rooms');
    Route::get('/admin/pokoje/dodaj', 'RoomsController@create')->name('admin.rooms.create');
    Route::post('/admin/pokoje', 'RoomsController@store')->name('admin.rooms.store');
    Route::get('/admin/{city}/{room}', 'RoomsController@edit')->name('admin.rooms.edit');
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

Route::get('/pokoje', 'RoomsController@index'); // Display all adverts.

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    
    // Adverts actions
    Route::post('/pokoje', 'RoomsController@store');
    Route::get('/pokoje/edytuj/{advert}', 'RoomsController@edit'); // Edit advert.
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
Route::get('/pokoje/dodaj', 'RoomsController@create');
Route::get('/pokoje/{advert}', 'RoomsController@show'); // Display a single advert.
