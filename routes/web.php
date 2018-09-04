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
Route::group(['middleware' => ['web', 'auth']], function (){
    Route::group(['middleware' => 'admin'],function(){
        Route::get('/', 'RestaurantsController@index')->name('home');
        Route::get('/customers', 'UsersController@index');
        Route::group(['prefix' => 'customer'], function () {
            Route::get('create', 'UsersController@create');
            Route::get('store', 'UsersController@store');
            Route::get('edit/{id}', 'UsersController@edit');
            Route::post('update/{id}', 'UsersController@update');
            Route::post('delete', 'UsersController@deleteCustomers');
        });
        Route::get('/areas', 'AreasController@index');
        Route::group(['prefix' => 'area'], function () {
            Route::get('store', 'AreasController@store');
            Route::post('update/{id}', 'AreasController@update');
            Route::post('delete', 'AreasController@deleteAreas');
        });
        Route::get('/restaurants', 'RestaurantsController@index');
        Route::group(['prefix' => 'restaurant'], function () {
            Route::get('create', 'RestaurantsController@create');
            Route::post('store', 'RestaurantsController@store');
            Route::get('edit/{id}', 'RestaurantsController@edit');
            Route::post('update/{id}', 'RestaurantsController@update');
            Route::post('delete', 'RestaurantsController@deleteRestaurants');
        });
        Route::get('/restaurant_categories', 'RestaurantCategoriesController@index');
        Route::group(['prefix' => 'restaurant_category'], function () {
            Route::get('store', 'RestaurantCategoriesController@store');
            Route::post('update/{id}', 'RestaurantCategoriesController@update');
            Route::post('delete', 'RestaurantCategoriesController@deleteRestaurantCategory');
        });
        Route::get('/categories', 'CategoriesController@index');
        Route::group(['prefix' => 'category'], function () {
            Route::get('create', 'CategoriesController@create');
            Route::get('store', 'CategoriesController@store');
            Route::get('edit/{id}', 'CategoriesController@edit');
            Route::post('update/{id}', 'CategoriesController@update');
            Route::post('delete', 'CategoriesController@deleteCategories');
        });
        Route::get('/collection_categories', 'CollectionCategoriesController@index');
        Route::group(['prefix' => 'collection_category'], function () {
            Route::get('store', 'CollectionCategoriesController@store');
            Route::post('update/{id}', 'CollectionCategoriesController@update');
            Route::post('delete', 'CollectionCategoriesController@deleteCategory');
        });
        Route::get('/menus/{id?}', 'MenusController@index');
        Route::group(['prefix' => 'menu'], function () {
            Route::get('create', 'MenusController@create');
            Route::post('store', 'MenusController@store');
            Route::get('edit/{id}', 'MenusController@edit');
            Route::post('update/{id}', 'MenusController@update');
            Route::post('delete', 'MenusController@deleteMenus');
        });
        Route::get('/collections/{id?}','CollectionsController@index');
        Route::group(['prefix' => 'collection'], function () {
            Route::get('create','CollectionsController@create');
            Route::get('store','CollectionsController@store');
            Route::get('edit/{id}', 'CollectionsController@edit');
            Route::post('update/{id}', 'CollectionsController@update');
            Route::post('delete','CollectionsController@deleteCollection');
        });
    });
});


