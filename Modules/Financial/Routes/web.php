<?php


namespace App;

use Auth;
use Session;

use Illuminate\Support\Facades\Route;
use Modules\Financial\Http\Controllers\FinancialController;



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

    Route::prefix('financial')->group(function () {
        Route::get('/create', 'FinancialController@create')->name('financial.create');
        Route::get('/index', 'FinancialController@index')->name('financial.index');
        Route::get('/sweet', 'FinancialController@sweet');
        Route::get('/edit/{slug}', 'FinancialController@edit')->name('financial.edit');
        Route::any('/destroy/{slug}', 'FinancialController@destroy');
        Route::any('/update/{slug}', 'FinancialController@update');
        Route::post('/store/{slug}', 'FinancialController@store')->name('financial.store');;
        Route::get('/show/{slug}', 'FinancialController@show')->name('financial.show');
        Route::get('/receipt/{slug}', 'FinancialController@receipt')->name('financial.receipt');
        Route::post('/rftstore/{slug}', 'FinancialController@rftstore')->name('financial.rftstore');;
        Route::get('/rftshow/{slug}', 'FinancialController@rftshow')->name('financial.rftshow');
        Route::get('/rftreceipt/{slug}', 'FinancialController@rftreceipt')->name('financial.rftreceipt');
    });

});

