<?php

/** Backend routes */

Route::get('/admin/login', 'Admin\AdminController@login')->middleware('guest')->name('admin.login');

Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function() 
{
    // Home
    Route::get('/admin', 'AdminController@index')->name('admin');
    
    // Cities
    Route::get('/admin/miasta', 'CitiesController@index')->name('admin.cities');
    Route::get('/admin/miasta/dodaj', 'CitiesController@create')->name('admin.cities.create');
    Route::post('/admin/miasta', 'CitiesController@store')->name('admin.cities.store');
    Route::get('/admin/miasta/{city}', 'CitiesController@edit')->name('admin.cities.edit');
    Route::patch('/admin/miasta/{city}', 'CitiesController@update')->name('admin.cities.update');

    // Streets
    Route::get('/admin/ulice/{city}', 'StreetsController@index')->name('admin.cities.streets');
    Route::post('/admin/ulice/{city}', 'StreetsController@store')->name('admin.streets.store');
    Route::get('/admin/ulice/{city}/{street}', 'StreetsController@edit')->name('admin.streets.edit');
    Route::post('/admin/ulice/{city}/{street}', 'StreetsController@update')->name('admin.streets.update');
    
    // Rooms
    Route::get('/admin/pokoje', 'RoomsController@index')->name('admin.rooms');
    Route::get('/admin/pokoje/dodaj', 'RoomsController@create')->name('admin.rooms.create');
    Route::post('/admin/pokoje', 'RoomsController@store')->name('admin.rooms.store');
    Route::get('/admin/pokoje/{room}', 'RoomsController@edit')->name('admin.rooms.edit');
    Route::patch('/admin/pokoje/{room}', 'RoomsController@update')->name('admin.rooms.update');
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