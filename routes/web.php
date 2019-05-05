<?php

/** Backend routes */

Route::get('/admin/login', 'Admin\AdminController@login')->middleware('guest')->name('admin.login');

Route::group(['namespace' => 'Admin', 'middleware' => 'admin', 'prefix' => 'admin'], function() 
{
    // Home
    Route::get('/', 'AdminController@index')->name('admin');
    
    // Cities
    Route::get('/miasta', 'CitiesController@index')->name('admin.cities');
    Route::get('/miasta/dodaj', 'CitiesController@create')->name('admin.cities.create');
    Route::post('/miasta', 'CitiesController@store')->name('admin.cities.store');
    Route::get('/miasta/{city}', 'CitiesController@edit')->name('admin.cities.edit');
    Route::get('/miasta/{city}/pokoje', 'CitiesController@adverts')->name('admin.cities.adverts');
    Route::patch('/miasta/{city}', 'CitiesController@update')->name('admin.cities.update');
    Route::delete('/miasta/{city}', 'CitiesController@destroy')->name('admin.cities.destroy');
    /* Route::resource('admin/cities', 'CitiesController' [
        'as' => 'admin'
    ]); */

    // Streets
    Route::get('/miasta/{city}/ulice', 'CityStreetsController@index')->name('admin.cities.streets');
    Route::get('/miasta/{city}/ulice/dodaj', 'CityStreetsController@create')->name('admin.streets.create');
    Route::post('/miasta/{city}/ulice', 'CityStreetsController@store')->name('admin.streets.store');
    Route::get('/miasta/{city}/ulice/{street}', 'CityStreetsController@edit')->name('admin.streets.edit');
    Route::patch('/miasta/{city}/ulice/{street}', 'CityStreetsController@update')->name('admin.streets.update');
    Route::delete('/miasta/{city}/ulice/{street}', 'CityStreetsController@destroy')->name('admin.streets.destroy');
    
    // Rooms
    Route::get('/pokoje', 'RoomsController@index')->name('admin.rooms');
    Route::get('/pokoje/dodaj', 'RoomsController@create')->name('admin.rooms.create');
    Route::post('/pokoje', 'RoomsController@store')->name('admin.rooms.store');
    Route::get('/pokoje/{room}', 'RoomsController@edit')->name('admin.rooms.edit');
    Route::patch('/pokoje/{room}', 'RoomsController@update')->name('admin.rooms.update');
    Route::delete('/pokoje/{room}', 'RoomsController@destroy')->name('admin.rooms.destroy');
});

/** Frontend routes */

Auth::routes();

Route::get('/', 'PagesController@index')->name('index');
Route::get('/home', 'PagesController@home')->name('home');

// Search
Route::get('/szukaj', 'SearchController@index')->name('search.index');

// Rooms
Route::get('/pokoje', 'RoomsController@index')->name('rooms');
Route::get('/{city}/pokoje/{room}', 'RoomsController@show')->name('rooms.show');

Route::group(['middleware' => 'auth'], function() 
{
    Route::get('/pokoje/dodaj', 'RoomsController@create')->name('rooms.create');
    Route::get('/pokoje/moje', 'RoomsController@mine')->name('rooms.mine');
    Route::post('/pokoje', 'RoomsController@store')->name('rooms.store');
    Route::get('/pokoje/{room}/edytuj', 'RoomsController@edit')->name('rooms.edit');
    Route::patch('/pokoje/{room}/edytuj', 'RoomsController@update')->name('rooms.update');
    Route::delete('/pokoje/{room}', 'RoomsController@destroy')->name('rooms.destroy');
});

// Cities
Route::get('/miasta', 'CitiesController@index')->name('cities');
Route::get('/{city}', 'CitiesController@show')->name('cities.show');

Route::group(['middleware' => 'auth'], function()
{
    // Conversations
    Route::get('/home/inbox', 'ConversationsController@inbox')->name('conversations.inbox');
    Route::post('/{city}/pokoje/{room}/odpowiedz', 'ConversationsController@store')->name('conversations.store');
    Route::get('/home/inbox/{conversation}', 'ConversationsController@show')->name('conversations.show');
    Route::post('/home/inbox/{conversation}', 'ConversationsController@reply')->name('conversations.reply');
});

// Ajax
Route::post('/ajax/cities', 'AjaxController@cities')->name('ajax.cities');
Route::post('/ajax/streets', 'AjaxController@streets')->name('ajax.streets');