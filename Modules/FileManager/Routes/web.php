<?php

namespace App;
use Auth;
use Modules\FileManager\Http\Controllers\FileManagerController;
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
    Route::prefix('apps')->group(function() {
        Route::get('/fileManager/{serviceType?}/{id?}/{path?}', [FileManagerController::class, 'index'])->name('file.index');
        Route::any('/fileManager/newFolder/{path}/{serviceType?}/{id?}/', [FileManagerController::class, 'newFolder'])->name('file.newFolder');
        Route::any('/fileManager/upload/', [FileManagerController::class, 'upload'])->name('file.upload');
        Route::any('/fileManager/delete/', [FileManagerController::class, 'delete'])->name('file.delete');
    });
});
