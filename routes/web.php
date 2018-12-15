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
Route::group(['middleware' => ['web', 'auth']], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/', 'RestaurantsController@index')->name('home');
        Route::get('/customers', 'UsersController@index');
        Route::group(['prefix' => 'customer'], function () {
//            Route::get('create', 'UsersController@create');
//            Route::get('store', 'UsersController@store');
//            Route::get('edit/{id}', 'UsersController@edit');
//            Route::post('update/{id}', 'UsersController@update');
            Route::post('delete', 'UsersController@deleteCustomer');
        });
        Route::get('/areas', 'AreasController@index');
        Route::group(['prefix' => 'area'], function () {
            Route::get('store', 'AreasController@store');
            Route::post('update/{id}', 'AreasController@update');
            Route::post('delete', 'AreasController@deleteArea');
        });
        Route::get('/statuses', 'StatusesController@index');
        Route::group(['prefix' => 'status'], function () {
            Route::get('store', 'StatusesController@store');
            Route::post('update/{id}', 'StatusesController@update');
            Route::post('delete', 'StatusesController@deleteStatus');
        });
        Route::get('/mealtimes', 'MealtimesController@index');
        Route::group(['prefix' => 'mealtime'], function () {
            Route::get('store', 'MealtimesController@store');
            Route::post('update/{id}', 'MealtimesController@update');
            Route::post('delete', 'MealtimesController@deleteMealtime');
        });
        Route::get('/restaurants', 'RestaurantsController@index');
        Route::group(['prefix' => 'restaurant'], function () {
            Route::get('create', 'RestaurantsController@create');
            Route::post('store', 'RestaurantsController@store');
            Route::get('edit/{id}', 'RestaurantsController@edit');
            Route::post('update/{id}', 'RestaurantsController@update');
            Route::post('edit_approve/{id}', 'RestaurantsController@editApprove');
            Route::get('edit_reject/{id}', 'RestaurantsController@editReject');
            Route::post('delete', 'RestaurantsController@deleteRestaurant');
            Route::post('status/update/{id}', 'RestaurantsController@changeStatus');
        });
        Route::get('/restaurant_categories', 'RestaurantCategoriesController@index');
        Route::group(['prefix' => 'restaurant_category'], function () {
            Route::post('store', 'RestaurantCategoriesController@store');
            Route::post('update/{id}', 'RestaurantCategoriesController@update');
            Route::post('delete', 'RestaurantCategoriesController@deleteRestaurantCategory');
        });
        Route::get('/menu_categories/{id?}', 'MenuCategoriesController@index');
        Route::group(['prefix' => 'menu_category'], function () {
            Route::get('create/{id?}', 'MenuCategoriesController@create');
            Route::post('store', 'MenuCategoriesController@store');
            Route::get('approve/{id}', 'MenuCategoriesController@approve');
            Route::get('reject/{id}', 'MenuCategoriesController@reject');
            Route::get('edit/{id}', 'MenuCategoriesController@edit');
            Route::post('update/{id}', 'MenuCategoriesController@update');
            Route::post('edit_approve/{id}', 'MenuCategoriesController@editApprove');
            Route::get('edit_reject/{id}', 'MenuCategoriesController@editReject');
            Route::post('delete', 'MenuCategoriesController@deleteCategory');
        });
        Route::get('/collection_categories', 'CollectionCategoriesController@index');
        Route::group(['prefix' => 'collection_category'], function () {
            Route::get('store', 'CollectionCategoriesController@store');
            Route::post('update/{id}', 'CollectionCategoriesController@update');
            Route::post('delete', 'CollectionCategoriesController@deleteCategory');
        });
        Route::get('/menus/{id?}', 'MenusController@index');
        Route::group(['prefix' => 'menu'], function () {
            Route::get('create/{id?}', 'MenusController@create');
            Route::post('store', 'MenusController@store');
            Route::get('approve/{id}', 'MenusController@approve');
            Route::get('reject/{id}', 'MenusController@reject');
            Route::get('edit/{id}', 'MenusController@edit');
            Route::post('update/{id}', 'MenusController@update');
            Route::post('edit_approve/{id}', 'MenusController@editApprove');
            Route::get('edit_reject/{id}', 'MenusController@editReject');
            Route::post('delete', 'MenusController@deleteMenu');
        });
        Route::get('/collections/{id?}', 'CollectionsController@index');
//        Route::post('collections/collection/copy/{id}', 'CollectionsController@copy');
        Route::group(['prefix' => 'collection'], function () {
            Route::get('create/{id?}', 'CollectionsController@create');
            Route::post('store', 'CollectionsController@store');
            Route::get('approve/{id}', 'CollectionsController@approve');
            Route::get('reject/{id}', 'CollectionsController@reject');
            Route::get('availability/edit/{id}', 'CollectionsController@editAvailability');
            Route::post('availability/update/{id}', 'CollectionsController@updateAvailability');
            Route::get('edit/{id}', 'CollectionsController@edit');
            Route::get('copy/{id}', 'CollectionsController@collectionCopy');
            Route::post('save/{id}', 'CollectionsController@collectionSave');
            Route::post('update/{id}', 'CollectionsController@update');
            Route::post('edit_approve/{id}', 'CollectionsController@editApprove');
            Route::get('edit_reject/{id}', 'CollectionsController@editReject');
            Route::post('delete', 'CollectionsController@deleteCollection');
        });
        Route::get('/orders/{id?}', 'OrdersController@index');
        Route::group(['prefix' => 'order'], function () {
            Route::get('edit/{id}', 'OrdersController@edit');
            Route::get('confirmation/{id}', 'OrdersController@orderConfirmation');
            Route::post('update/{id}', 'OrdersController@update');
//            Route::post('delete', 'OrdersController@deleteOrder');
        });
        Route::get('/reviews/{id?}', 'ReviewsController@index');
//        Route::post('/review/delete', 'ReviewsController@deleteReview');
        Route::get('/admin/edit/{id}', 'UsersController@editAdmin');
        Route::post('/admin/update/{id}', 'UsersController@updateAdmin');
        Route::get('/languages', 'LanguagesController@index');
        Route::group(['prefix' => 'language'], function () {
            Route::get('create', 'LanguagesController@create');
            Route::post('store', 'LanguagesController@store');
            Route::get('edit/{id}', 'LanguagesController@edit');
            Route::post('update/{id}', 'LanguagesController@update');
            Route::post('delete', 'LanguagesController@deleteLanguage');
        });
    });
});


//Route::get('/test','TestController@index');
//
//Route::get('/sender', 'TestController@sender');
//
//Route::post('/message', 'TestController@test');




