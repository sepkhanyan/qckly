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
Route::post('/createCart', 'UserCartsController@createCart');
Route::get('/collectionDetails', 'UserCartsController@collectionDetails');
Route::get('/showCart/{id}', 'UserCartsController@showCart');
Route::get('/cartCount', 'UserCartsController@cartCount');
Route::post('/removeCart/{id}', 'UserCartsController@removeCart');
Route::get('/changeDeliveryAddress/{id}', 'UserCartsController@changeDeliveryAddress');
Route::get('/changeDefaultAddress/{id}', 'AddressesController@changeDefaultAddress');
Route::post('/addAddress/{id?}', 'AddressesController@addAddress');
Route::get('/getAddresses', 'AddressesController@getAddresses');
Route::get('/deleteAddress/{id}', 'AddressesController@deleteAddress');
Route::post('/completeOrder', 'OrdersController@completeOrder');
Route::get('/orderList', 'OrdersController@orderList');
Route::post('/rateOrder', 'ReviewsController@rateOrder');
Route::get('/reviews', 'ReviewsController@reviews');
Route::get('/login', 'UsersController@login');
Route::get('/submitOtp', 'UsersController@submitOtp');
Route::get('/resendOtp', 'UsersController@resendOtp');
Route::post('/completeProfile', 'UsersController@completeProfile');
Route::get('/getUserDetails', 'UsersController@getUserDetails');
Route::get('/allDevicesPost', 'UsersController@allDevicesPost');
Route::get('/changeLanguage', 'UsersController@changeLanguage');
