<?php

namespace App;
use Auth;
use Modules\TDMS\Http\Controllers\TDMSController;
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
    Route::prefix('tdms')->group(function() {
        Route::get('/index', [TDMSController::class, 'index'])->name('tdms.index');
        Route::get('/create', [TDMSController::class, 'create'])->name('tdms.create');
        Route::post('/store', [TDMSController::class, 'store'])->name('tdms.store');
        Route::any('/destroy/{id}', [TDMSController::class, 'destroy'])->name('tdms.destroy');
        Route::get('/withdraw', [TDMSController::class, 'withdraw'])->name('tdms.withdraw');
        Route::get('/show/{id}', [TDMSController::class, 'show'])->name('tdms.show');
        Route::get('/edit/{id}', [TDMSController::class, 'edit'])->name('tdms.edit');
        Route::any('/update/{id}', [TDMSController::class, 'update'])->name('tdms.update');
        Route::get('/getMasterList/', [TDMSController::class, 'getMasterList'])->name('tdms.getMasterList');
        Route::get('/getWithdrawList/', [TDMSController::class, 'getWithdrawList'])->name('tdms.getWithdrawList');
        Route::post('/getMasterSystem/', [TDMSController::class, 'getMasterSystem'])->name('tdms.getMasterSystem');
        Route::get('/getMasterSystems/{slug}', [TDMSController::class, 'getMasterSystems'])->name('tdms.getMasterSystems');
        Route::get('/revision/{id}', [TDMSController::class, 'revision'])->name('tdms.revision');
        Route::any('/revisions/{id}', [TDMSController::class, 'revisions'])->name('tdms.revisions');
        Route::get('/getExternalPdf/{id}', [TDMSController::class, 'getExternalPdf'])->name('tdms.getExternalPdf');
        Route::get('/getPdf/{id}', [TDMSController::class, 'getPdf'])->name('tdms.getPdf');
        Route::get('/streamPdf/{id}', [TDMSController::class, 'streamPdf'])->name('tdms.streamPdf');
        Route::get('/streamPdf2/{id}', [TDMSController::class, 'streamPdf2'])->name('tdms.streamPdf2');
        Route::get('/getNative/{id}', [TDMSController::class, 'getNative'])->name('tdms.getNative');
        Route::get('/indexExternalDocument', [TDMSController::class, 'indexExternalDocument'])->name('tdms.indexExternalDocument');
        Route::get('/createExternalDocument', [TDMSController::class, 'createExternalDocument'])->name('tdms.createExternalDocument');
        Route::post('/storeExternalDocument', [TDMSController::class, 'storeExternalDocument'])->name('tdms.storeExternalDocument');
        Route::get('/showExternalDocument/{id}', [TDMSController::class, 'showExternalDocument'])->name('tdms.showExternalDocument');
        Route::get('/editExternalDocument/{id}', [TDMSController::class, 'editExternalDocument'])->name('tdms.editExternalDocument');
        Route::any('/updateExternalDocument/{id}', [TDMSController::class, 'updateExternalDocument'])->name('tdms.updateExternalDocument');
        Route::get('/getExternalDocumentMasterList/', [TDMSController::class, 'getExternalDocumentMasterList'])->name('tdms.getExternalDocumentMasterList');
    });

});
