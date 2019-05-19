<?php

/****************
 * Backend routes 
 ***************/

Route::get('/admin/login', 'Admin\AdminLoginController@index')->middleware('guest')->name('admin.login');

Route::group(['namespace' => 'Admin', 'middleware' => 'admin', 'prefix' => 'admin'], function() 
{
    // Home
    Route::get('/', 'AdminDashboardController@index')->name('admin');
    
    // Cities
    Route::get('/miasta', 'CitiesController@index')->name('admin.cities');
    Route::get('/miasta/dodaj', 'CitiesController@create')->name('admin.cities.create');
    Route::post('/miasta', 'CitiesController@store')->name('admin.cities.store');
    Route::get('/miasta/{city}', 'CitiesController@edit')->name('admin.cities.edit');
    Route::get('/miasta/{city}/pokoje', 'CitiesController@adverts')->name('admin.cities.adverts'); // @Refactor
    Route::patch('/miasta/{city}', 'CitiesController@update')->name('admin.cities.update');
    Route::delete('/miasta/{city}', 'CitiesController@destroy')->name('admin.cities.destroy');

    // Streets
    Route::get('/miasta/{city}/ulice', 'CityStreetsController@index')->name('admin.cities.streets');
    Route::get('/miasta/{city}/ulice/dodaj', 'CityStreetsController@create')->name('admin.streets.create');
    Route::post('/miasta/{city}/ulice', 'CityStreetsController@store')->name('admin.streets.store');
    Route::get('/miasta/{city}/ulice/{street}', 'CityStreetsController@edit')->name('admin.streets.edit');
    Route::patch('/miasta/{city}/ulice/{street}', 'CityStreetsController@update')->name('admin.streets.update');
    Route::delete('/miasta/{city}/ulice/{street}', 'CityStreetsController@destroy')->name('admin.streets.destroy');
    
    // Adverts
    Route::get('/pokoje', 'AdvertsController@index')->name('admin.adverts');
    Route::get('/pokoje/dodaj', 'AdvertsController@create')->name('admin.adverts.create');
    Route::post('/pokoje', 'AdvertsController@store')->name('admin.adverts.store');
    Route::get('/pokoje/{advert}', 'AdvertsController@edit')->name('admin.adverts.edit');
    Route::patch('/pokoje/{advert}', 'AdvertsController@update')->name('admin.adverts.update');
    Route::delete('/pokoje/{advert}', 'AdvertsController@destroy')->name('admin.adverts.destroy');
});


/*****************
 * Frontend routes 
 ****************/

Auth::routes(['verify' => true]);

Route::get('/', 'PagesController@index')->name('index');

// Search
Route::get('/szukaj', 'SearchController@index')->name('search.index');

// Adverts
Route::get('/pokoje', 'AdvertsController@index')->name('adverts');
Route::get('/pokoje/{city}/{advert}', 'AdvertsController@show')->name('adverts.show');

Route::group(['middleware' => ['auth', 'verified']], function() 
{
    // Subscriptions
    Route::post('/pokoje/{city}/obserwuj', 'CitySubscriptionsController@store')->name('city.subscribe');
    Route::delete('/pokoje/{city}/obserwuj', 'CitySubscriptionsController@destroy')->name('city.unsubscribe');
    
    Route::get('/home', 'PagesController@home')->name('home'); // @Refactor
    Route::get('/pokoje/moje', 'AdvertsController@mine')->name('adverts.mine'); // @Refactor
    Route::get('/pokoje/dodaj', 'AdvertsController@create')->name('adverts.create');
    Route::post('/pokoje', 'AdvertsController@store')->name('adverts.store');
    Route::get('/pokoje/{city}/{advert}/edytuj', 'AdvertsController@edit')->name('adverts.edit');
    Route::patch('/pokoje/{city}/{advert}/edytuj', 'AdvertsController@update')->name('adverts.update');
    Route::delete('/pokoje/{city}/{advert}', 'AdvertsController@destroy')->name('adverts.destroy');

    // Favourites
    Route::post('/pokoje/{city}/{advert}/ulubione', 'FavouritesController@store')->name('adverts.favourite.store');
    Route::delete('/pokoje/{city}/{advert}/ulubione', 'FavouritesController@destroy')->name('adverts.favourite.delete');

});

// Cities
Route::get('/miasta', 'CitiesController@index')->name('cities');
Route::get('/pokoje/{city}', 'CitiesController@show')->name('cities.show');

Route::group(['middleware' => 'auth'], function()
{
    // Conversations
    Route::get('/home/inbox', 'ConversationsController@inbox')->name('conversations.inbox');
    Route::post('/{city}/pokoje/{advert}/odpowiedz', 'ConversationsController@store')->name('conversations.store');
    Route::get('/home/inbox/{conversation}', 'ConversationsController@show')->name('conversations.show');
    Route::post('/home/inbox/{conversation}', 'ConversationsController@reply')->name('conversations.reply');
});

// Users
Route::get('/uzytkownicy/{user}', 'ProfilesController@show')->name('profiles.show');

// Notifications
Route::get('/uzytkownicy/{user}/notyfikacje', 'UserNotificationsController@index')->name('profiles.notifications');
Route::delete('/uzytkownicy/{user}/notyfikacje/{notification}', 'UserNotificationsController@destroy')->name('profiles.notifications.delete');

// Ajax @Refactor
Route::get('/ajax/cities', 'AjaxController@cities');
Route::get('/ajax/streets', 'AjaxController@streets');
Route::post('/ajax/images/upload', 'AjaxController@upload');
Route::get('/pokoje/{city}/ajax/adverts', 'AjaxController@index')->name('ajax.city.adverts');

// Api
Route::post('/api/uzytkownicy/{user}/avatars', 'Api\AvatarsController@store')->middleware('auth')->name('api.users.avatars.store');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
