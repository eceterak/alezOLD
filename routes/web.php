<?php

/****************
 * Backend routes 
 ***************/

Route::get('/admin/login', 'Admin\AdminLoginController@index')->middleware('guest')->name('admin.login');

Route::group(['namespace' => 'Admin', 'middleware' => 'admin', 'prefix' => 'admin'], function() 
{
    // Home
    Route::get('/', 'AdminDashboardController@index')->name('admin.dashboard');
    
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

    // Verification
    Route::post('/pokoje/{advert}/weryfikuj', 'AdvertsVerificationController@store')->name('admin.adverts.verify');
    // Revision
    Route::post('/pokoje/{advert}/zmiany', 'AdvertsRevisionController@store')->name('admin.adverts.revision.store');
    Route::delete('/pokoje/{advert}/zmiany', 'AdvertsRevisionController@destroy')->name('admin.adverts.revision.destroy');

    // Profiles
    Route::get('/uzytkownicy', 'ProfilesController@index')->name('admin.profiles');

    // Notifications
    Route::get('/notyfikacje', 'NotificationsController@index')->name('admin.notifications');
});


/*****************
 * Frontend routes 
 ****************/

Route::get('/', 'PagesController@index')->name('index'); //@refactor - I dont like the name pagesController

// Search
Route::get('/szukaj', 'SearchController@index')->name('search.index');

// Adverts
Route::get('/pokoje', 'AdvertsController@index')->name('adverts');
Route::get('/pokoje/{city}/{advert}', 'AdvertsController@show')->name('adverts.show');

Route::group(['middleware' => ['auth', 'verified']], function() 
{
    // Subscriptions //@refactor to API
    Route::get('/moj-alez/obserwowane', 'CitySubscriptionsController@index')->name('subscriptions');
    Route::post('/pokoje/{city}/obserwuj', 'CitySubscriptionsController@store')->name('city.subscribe');
    Route::delete('/pokoje/{city}/obserwuj', 'CitySubscriptionsController@destroy')->name('city.unsubscribe');

    // User account
    Route::get('/moj-alez', 'HomeController@index')->name('home');
    Route::get('/moj-alez/archiwum', 'ArchivesController@index')->name('archives');
    Route::get('/moj-alez/ustawienia', 'Auth\UserSettingsController@index')->name('settings');
    Route::post('/moj-alez/ustawienia', 'Auth\UserSettingsController@update')->name('settings.update');
    Route::delete('/moj-alez', 'Auth\UserSettingsController@destroy')->name('account.delete');

    // Passwords
    Route::get('/moj-alez/zmien-haslo', 'Auth\PasswordChangeController@index')->name('password.change');
    Route::post('/moj-alez/zmien-haslo', 'Auth\PasswordChangeController@update')->name('password.change.store');

    // Conversations
    Route::group(['namespace' => 'Conversations'], function() {
        Route::get('/moj-alez/odebrane', 'InboxController@index')->name('conversations.inbox');
        Route::get('/moj-alez/wyslane', 'SentController@index')->name('conversations.sent');
        Route::get('/moj-alez/{advert}/odebrane', 'AdvertConversationController@show')->name('conversations.advert');
        Route::post('/pokoje/{city}/{advert}/odpowiedz', 'ConversationsController@store')->middleware('throttle:10,1')->name('conversations.store');
        Route::get('/moj-alez/odebrane/{conversation}', 'ConversationsController@show')->name('conversations.show');
        Route::post('/moj-alez/odebrane/{conversation}', 'MessagesController@store')->middleware('throttle:15,1')->name('conversations.reply');
    });

    // Adverts
    Route::get('/pokoje/dodaj', 'AdvertsController@create')->name('adverts.create');
    Route::post('/pokoje', 'AdvertsController@store')->name('adverts.store');
    Route::get('/pokoje/{city}/{advert}/edytuj', 'AdvertsController@edit')->name('adverts.edit');
    Route::patch('/pokoje/{city}/{advert}/edytuj', 'AdvertsController@update')->name('adverts.update');
    Route::delete('/pokoje/{city}/{advert}', 'AdvertsController@destroy')->name('adverts.destroy');

    // Favourites //@refactor to API
    Route::get('/moj-alez/ulubione', 'FavouritesController@index')->name('favourites');
    Route::post('/pokoje/{city}/{advert}/ulubione', 'FavouritesController@store')->name('adverts.favourite.store');
    Route::delete('/pokoje/{city}/{advert}/ulubione', 'FavouritesController@destroy')->name('adverts.favourite.delete');

    // Notifications
    Route::get('/uzytkownicy/{user}/notyfikacje', 'UserNotificationsController@index')->name('profiles.notifications');
    Route::delete('/uzytkownicy/{user}/notyfikacje/{notification}', 'UserNotificationsController@destroy')->name('profiles.notifications.delete');
});

// Pages
Route::get('/regulamin', 'PagesController@termsAndConditions')->name('termsAndConditions');
Route::get('/polityka-prywatnosci', 'PagesController@privacyPolicy')->name('privacyPolicy');
Route::get('/o-nas', 'PagesController@aboutUs')->name('aboutUs');
Route::get('/contact', 'PagesController@contact')->name('contact');

// Cities
Route::get('/miasta', 'CitiesController@index')->name('cities');
Route::get('/pokoje/{city}', 'CitiesController@show')->name('cities.show');

// Profiles
Route::get('/uzytkownicy/{user}', 'ProfilesController@show')->name('profiles.show');

// Ajax @Refactor to API
Route::get('/ajax/cities', 'AjaxController@cities');
Route::get('/ajax/streets', 'AjaxController@streets');
Route::post('/ajax/images/upload', 'AjaxController@upload');
Route::get('/pokoje/{city}/ajax/adverts', 'AjaxController@index')->name('ajax.city.adverts');

// Api
Route::post('/api/uzytkownicy/{user}/avatars', 'Api\AvatarsController@store')->middleware('auth')->name('api.users.avatars.store');
Route::delete('/api/uzytkownicy/{user}/avatars', 'Api\AvatarsController@destroy')->middleware('auth')->name('api.users.avatars.delete');

// Photos
Route::post('/api/ogloszenia/zdjecia/{key}', 'Api\PhotosUploadController@store')->middleware('auth')->name('api.adverts.photos.store');
Route::delete('/api/ogloszenia/zdjecia/{photo}/{key}', 'Api\PhotosUploadController@destroy')->middleware('auth')->name('api.adverts.photos.delete');
Route::patch('/api/ogloszenia/zdjecia/{advert}', 'Api\PhotosUploadController@update')->middleware('auth')->name('api.adverts.photos.update');
Route::patch('/api/zdjecia/{advert}', 'Api\PhotosOrderController@update')->middleware('auth')->name('api.photos.order.update');

Route::post('/api/zdjecia/{advert}/weryfikuj', 'Api\PhotosVerificationController@store')->middleware('admin')->name('api.photos.verify.bulk');
Route::patch('/api/zdjecia/{photo}/weryfikuj', 'Api\PhotosVerificationController@update')->middleware('admin')->name('api.photos.verify');

Route::get('/api/ogloszenia/{advert}/phone', 'Api\DisplayPhoneNumberController@show')->name('api.adverts.phone');

// Auth
Auth::routes(['verify' => true]);
Auth::routes();