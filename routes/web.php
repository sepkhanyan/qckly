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
            Route::get('/customers', 'UsersController@index');
            Route::get('/customer/create', 'UsersController@create');
            Route::get('/customer/store', 'UsersController@store');
            Route::get('/customer/edit/{id}', 'UsersController@edit');
            Route::post('/customer/update/{id}', 'UsersController@update');
            Route::post('/customer/delete', 'UsersController@deleteCustomers');
            Route::get('/areas', 'AreasController@index');
            Route::get('/area/create', 'AreasController@create');
            Route::get('/area/store', 'AreasController@store');
            Route::get('/area/edit/{id}', 'AreasController@edit');
            Route::post('/area/update/{id}', 'AreasController@update');
            Route::post('/area/delete', 'AreasController@deleteAreas');
            Route::get('/restaurants', 'RestaurantsController@index');
            Route::get('/restaurant/create', 'RestaurantsController@create');
            Route::post('/restaurant/store', 'RestaurantsController@store');
            Route::get('/restaurant/edit/{id}', 'RestaurantsController@edit');
            Route::post('/restaurant/update/{id}', 'RestaurantsController@update');
            Route::post('/restaurant/delete', 'RestaurantsController@deleteRestaurants');
            Route::get('/restaurant_categories', 'RestaurantCategoriesController@index');
            Route::get('/restaurant_category/create', 'RestaurantCategoriesController@create');
            Route::post('/restaurant_category/store', 'RestaurantCategoriesController@store');
            Route::get('/restaurant_category/edit/{id}', 'RestaurantCategoriesController@edit');
            Route::post('/restaurant_category/update/{id}', 'RestaurantCategoriesController@update');
            Route::post('/restaurant_category/delete', 'RestaurantCategoriesController@deleteRestaurantCategory');
            Route::get('/categories', 'CategoriesController@index');
            Route::get('/category/create', 'CategoriesController@create');
            Route::get('/category/store', 'CategoriesController@store');
            Route::get('/category/edit/{id}', 'CategoriesController@edit');
            Route::post('/category/update/{id}', 'CategoriesController@update');
            Route::post('/category/delete', 'CategoriesController@deleteCategories');
            Route::get('/menu_subcategories', 'MenuSubcategoriesController@index');
            Route::get('/menu_subcategory/store', 'MenuSubcategoriesController@store');
            Route::get('/menu_subcategory/edit/{id}', 'MenuSubcategoriesController@edit');
            Route::post('/menu_subcategory/update/{id}', 'MenuSubcategoriesController@update');
            Route::post('/menu_subcategory/delete', 'MenuSubcategoriesController@deleteSubcategory');
            Route::get('/menus/{id?}', 'MenusController@index');
            Route::get('/menu/create', 'MenusController@create');
            Route::post('/menu/store', 'MenusController@store');
            Route::get('/menu/edit/{id}', 'MenusController@edit');
            Route::post('/menu/update/{id}', 'MenusController@update');
            Route::post('/menu/delete', 'MenusController@deleteMenus');
            Route::get('/collections/{id?}','CollectionsController@index');
            Route::get('/collection/create','CollectionsController@create');
            Route::get('/collection/store','CollectionsController@store');
            Route::get('/collection/edit/{id}', 'CollectionsController@edit');
            Route::post('/collection/update/{id}', 'CollectionsController@update');
            Route::post('/collection/delete','CollectionsController@deleteCollection');
    });
});


