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
            Route::get('/', 'HomeController@test')->name('home');
            Route::get('/new/customers', 'UsersController@create');
            Route::get('/store/customers', 'UsersController@store');
            Route::get('/customers', 'UsersController@index');
            Route::get('/customer/edit/{id}', 'UsersController@edit');
            Route::post('/customer/update/{id}', 'UsersController@update');
            Route::post('/delete/customers', 'UsersController@deleteCustomers');
            Route::get('/areas', 'AreasController@index');
            Route::get('/new/areas', 'AreasController@create');
            Route::get('/store/areas', 'AreasController@store');
            Route::get('/area/edit/{id}', 'AreasController@edit');
            Route::post('/area/update/{id}', 'AreasController@update');
            Route::post('/delete/areas', 'AreasController@deleteAreas');
            Route::get('/restaurants', 'RestaurantsController@index');
            Route::get('/new/restaurants', 'RestaurantsController@create');
            Route::post('/store/restaurants', 'RestaurantsController@store');
            Route::get('/restaurant/edit/{id}', 'RestaurantsController@edit');
            Route::post('/restaurant/update/{id}', 'RestaurantsController@update');
            Route::post('/delete/restaurants', 'RestaurantsController@deleteRestaurants');
            Route::get('/restaurant_categories', 'RestaurantCategoriesController@index');
            Route::get('/new/restaurant_category', 'RestaurantCategoriesController@create');
            Route::post('/store/restaurant_category', 'RestaurantCategoriesController@store');
            Route::post('/delete/restaurant_category', 'RestaurantCategoriesController@deleteRestaurantCategory');
            Route::get('/restaurant_category/edit/{id}', 'RestaurantCategoriesController@edit');
            Route::post('/restaurant_category/update/{id}', 'RestaurantCategoriesController@update');
            Route::get('/categories', 'CategoriesController@index');
            Route::get('/new/categories', 'CategoriesController@create');
            Route::get('/store/categories', 'CategoriesController@store');
            Route::get('/category/edit/{id}', 'CategoriesController@edit');
            Route::post('/category/update/{id}', 'CategoriesController@update');
            Route::post('/delete/categories', 'CategoriesController@deleteCategories');
            Route::get('/menu_subcategories', 'MenuSubcategoriesController@index');
            Route::get('/menu_subcategory/store', 'MenuSubcategoriesController@store');
            Route::post('/delete/menu_subcategory', 'MenuSubcategoriesController@deleteSubcategory');
            Route::get('/menu_subcategory/edit/{id}', 'MenuSubcategoriesController@edit');
            Route::post('/menu_subcategory/update/{id}', 'MenuSubcategoriesController@update');
            Route::get('/menus/{id?}', 'MenusController@index');
            Route::get('/new/menus', 'MenusController@create');
            Route::post('/store/menus', 'MenusController@store');
            Route::get('/menu/edit/{id}', 'MenusController@edit');
            Route::post('/menu/update/{id}', 'MenusController@update');
            Route::post('/delete/menus', 'MenusController@deleteMenus');
            Route::get('/collections/{id?}','CollectionsController@index');
            Route::get('/new/collection','CollectionsController@create');
            Route::get('/collection/store','CollectionsController@store');
            Route::post('/delete/collection','CollectionsController@deleteCollection');
            Route::get('/collection/edit/{id}', 'CollectionsController@edit');
            Route::post('/collection/update/{id}', 'CollectionsController@update');
//            Route::get('/orders','OrdersController@index');

        });
});


