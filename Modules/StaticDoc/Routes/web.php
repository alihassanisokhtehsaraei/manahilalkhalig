<?php

use Illuminate\Support\Facades\Route;
use Modules\StaticDoc\Http\Controllers\StaticDocController;


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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::prefix('staticDocs')->name('staticDocs.')->controller(StaticDocController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/download/{index}', 'download')->name('download');
    });


});
