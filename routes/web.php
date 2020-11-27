<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@welcome')->name('home');

Route::get('login/google', 'LoginController@redirectToProvider')->name('login.google');
Route::get('login/google/callback', 'LoginController@handleProviderCallback')->name('login.google.callback');
Route::get('register/google', 'RegisterController@redirectToProvider')->name('register.google');
Route::get('register/google/callback', 'RegisterController@handleProviderCallback')->name('register.google.callback');

Route::middleware('can:isBuyerOrGuest')->group(function (){
    Route::get('search', 'ProductController@search')->name('search');
    Route::get('cart', 'CartController@index')->name('carts.index');
    Route::get('cart/{product}', 'CartController@store')->name('carts.add');
    Route::delete('cart/{cart}', 'CartController@destroy')->name('carts.destroy');
    Route::patch('cart/{cart}', 'CartController@update')->name('carts.update');
    Route::get('sellers/{seller}', 'SellerController@show')->name('sellers.show');
});

Route::middleware('auth')->group(function (){

    Route::get('login/redirect', 'LoginController@redirectToHome')->name('login.redirect');

    Route::prefix('profile/')->group(function (){
        Route::get('/', 'ProfileController@profile')->name('profile');
        Route::put('password', 'ProfileController@addPassword')->name('profile.password');
        Route::get('google', 'ProfileController@redirectToProvider')->name('profile.google');
        Route::get('google/avatar', 'ProfileController@showAvatar')->name('profile.google.avatar');
        Route::get('google/callback', 'ProfileController@handleProviderCallback')->name('profile.google.callback');
        Route::get('google/disconnect', 'ProfileController@disconnectProvider')->name('profile.google.disconnect');
        Route::post('seller', 'ProfileController@updateSeller')->name('profile.seller')->middleware('can:isSeller');
        Route::post('buyer', 'ProfileController@updateBuyer')->name('profile.buyer')->middleware('can:isBuyer');
    });

    Route::middleware('can:isAdmin')->group(function (){

    });

    Route::middleware('can:isAdminOrSeller')->prefix('manage')->namespace('Manage')->group(function (){
        Route::get('/', 'DashboardController@index')->name('manage');

        Route::get('users/{user}', 'UserController@show')->name('manage.users.show');
        Route::resource('buyers', BuyerController::class, ['as' => 'manage'])->only(['index']);
        Route::resource('sellers', SellerController::class, ['as' => 'manage'])->only(['index']);

        Route::resource('products', ProductController::class, ['as' => 'manage']);
    });

    Route::middleware('can:isSellerHasStore')->prefix('manage')->namespace('Manage')->group(function (){
        Route::resource('categories', CategoryController::class, ['as' => 'manage']);

        Route::patch('products/{product}/update-stock', 'ProductController@updateStock')->name('manage.products.update-stock');
        Route::get('open-hours', 'DayController@index')->name('manage.open-hours.index');
        Route::patch('open-hours', 'DayController@update')->name('manage.open-hours.update');
    });

    Route::middleware('can:isBuyerRegistered')->group(function (){
        Route::get('orders/{type?}', 'OrderController@index')->name('orders.index');
        Route::get('orders/cart/{seller}', 'OrderController@create')->name('orders.create');
        Route::get('orders/detail/{order}', 'OrderController@show')->name('orders.show');
        Route::patch('orders/detail/{order}/payment', 'OrderController@updatePayment')->name('orders.payment');
    });
});
