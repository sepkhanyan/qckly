<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/areas', 'AreasController@getAreas');
Route::get('/restaurants', 'RestaurantsController@getRestaurants');
Route::post('/availableRestaurants', 'RestaurantsController@availableRestaurants');
Route::get('/restaurant/{id}', 'RestaurantsController@getRestaurant');
Route::get('/restaurantCategories', 'RestaurantCategoriesController@getCategories');
Route::post('/restaurantByCategory', 'RestaurantsController@getRestaurantByCategory');
Route::post('/restaurantMenuItems', 'RestaurantsController@restaurantMenuItems');
Route::post('/addToCart', 'UserCartsController@addToCart');
Route::post('/removeFromCart', 'UserCartsController@removeFromCart');
