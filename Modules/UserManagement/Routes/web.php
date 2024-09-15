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
use Modules\UserManagement\Http\Controllers\UserManagementController;
use Session;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::prefix('usermanagement')->group(function () {
        Route::get('/index', [UserManagementController::class, 'index'])->name('user.index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('user.create');
        Route::post('/store', [UserManagementController::class, 'store'])->name('user.store');
        Route::any('/destroy/{id}', [UserManagementController::class, 'destroy'])->name('user.destroy');
        Route::get('/edit/{id}', [UserManagementController::class, 'edit'])->name('user.edit');
        Route::any('/update/{id}', [UserManagementController::class, 'update'])->name('user.update');
    });

});
