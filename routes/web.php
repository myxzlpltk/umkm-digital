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

Route::middleware('auth')->group(function (){

    Route::get('login/redirect', 'LoginController@redirectToHome')->name('login.redirect');

    Route::prefix('profile/')->group(function (){
        Route::get('/', 'ProfileController@profile')->name('profile');
        Route::put('password', 'ProfileController@addPassword')->name('profile.password');
        Route::get('google', 'ProfileController@redirectToProvider')->name('profile.google');
        Route::get('google/avatar', 'ProfileController@showAvatar')->name('profile.google.avatar');
        Route::get('google/callback', 'ProfileController@handleProviderCallback')->name('profile.google.callback');
        Route::get('google/disconnect', 'ProfileController@disconnectProvider')->name('profile.google.disconnect');
        Route::post('seller', 'ProfileController@updateSeller')->name('profile.seller');
        Route::post('buyer', 'ProfileController@updateBuyer')->name('profile.buyer');
    });

    Route::middleware('can:isAdmin')->group(function (){

    });

    Route::middleware('can:isAdminOrSeller')->prefix('manage')->namespace('Manage')->group(function (){
        Route::get('/', 'DashboardController@index')->name('manage');

        Route::prefix('buyers')->group(function (){
            Route::get('/', 'BuyerController@index')->name('manage.buyers.index');
        });

        Route::prefix('sellers')->group(function (){
            Route::get('/', 'SellerController@index')->name('manage.sellers.index');
        });

        Route::prefix('products')->group(function (){
            Route::get('/', 'ProductController@index')->name('manage.product.index');
        });

        Route::prefix('categories')->group(function (){
            Route::get('/', 'CategoryController@index')->name('manage.categories.index');
        });
    });

    Route::middleware('can:isSeller')->group(function (){

    });
});
