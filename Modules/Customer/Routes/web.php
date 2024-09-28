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
namespace App;
use Auth;
use Session;

use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    Route::prefix('customer')->group(function() {
        Route::get('/create', 'CustomerController@create')->name('customer.create');
        Route::get('/index', 'CustomerController@index')->name('customer.index');
        Route::get('/sweet', 'CustomerController@sweet');
        Route::get('/edit/{$slug}', 'CustomerController@edit')->name('customer.edit');
        Route::post('/store', 'CustomerController@store');
        Route::any('/destroy/{slug}', 'CustomerController@destroy');
        Route::any('/update/{slug}', 'CustomerController@update');
        Route::get('/show/{slug}', 'CustomerController@show')->name('customer.show');
    });

});

