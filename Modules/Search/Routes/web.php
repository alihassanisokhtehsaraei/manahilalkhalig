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
use Modules\Search\Http\Controllers\SearchController;
use Session;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::prefix('search')->group(function () {
        Route::any('/index', [SearchController::class, 'index'])->name('search.index');
        Route::any('/result', [SearchController::class, 'result'])->name('search.result');
    });

});

