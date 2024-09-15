<?php

namespace App;
use App\Http\Controllers\ManagementController;
use Auth;
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
    Route::get('/', [ManagementController::class, 'index'])->name('root');
    Route::get('/dashboard', [ManagementController::class, 'index'])->name('dashboard');

    Route::get('/home', function () {
        return view('home');
    })->name('home');


    Route::Get('/php', function () {
        //   print_r(get_loaded_extensions());
        print_r(phpinfo());
    });

    Route::get('/view-pdf', [ManagementController::class, 'viewPdf'])->name('view.pdf');


});
