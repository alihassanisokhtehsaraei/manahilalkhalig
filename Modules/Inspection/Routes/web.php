<?php

namespace App;

use Auth;
use Modules\Inspection\Http\Controllers\InspectionController;
use Modules\Inspection\Http\Controllers\InsDocController;
use Modules\Inspection\Http\Controllers\InspectorController;
use Modules\Inspection\Http\Controllers\LabFeeController;
use Modules\Inspection\Http\Controllers\NonReleaseDocumentController;
use Modules\Inspection\Http\Controllers\ReleaseDocumentController;
use Modules\Inspection\Http\Controllers\ReportsController;
use Modules\Inspection\Http\Controllers\BankAcceptanceController;
use Modules\Inspection\Http\Controllers\CoiController;
use Modules\Inspection\Http\Controllers\LcController;
use Modules\Inspection\Http\Controllers\OrderController;
use Modules\Inspection\Http\Controllers\CocController;
use Modules\Inspection\Http\Controllers\NCRController;
use Modules\Inspection\Http\Controllers\WordController;
use Modules\Inspection\Http\Controllers\RequestController;
use Modules\Inspection\Http\Controllers\RftController;
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
    Route::prefix('inspector')->group(function () {
        Route::get('/index', [inspectorController::class, 'index'])->name('inspector.index');
        Route::get('/create', [inspectorController::class, 'create'])->name('inspector.create');
        Route::post('/store', [inspectorController::class, 'store'])->name('inspector.store');
        Route::any('/getcv/{id}', [inspectorController::class, 'getcv'])->name('inspector.getcv');
        Route::any('/destroy/{id}', [inspectorController::class, 'destroy'])->name('inspector.destroy');
        Route::get('/show/{id}', [inspectorController::class, 'show'])->name('inspector.show');
        Route::get('/edit/{id}', [inspectorController::class, 'edit'])->name('inspector.edit');
        Route::any('/update/{id}', [inspectorController::class, 'update'])->name('inspector.update');
    });

    Route::prefix('order')->group(function () {
        Route::get('/create/{slug?}', [OrderController::class, 'create'])->name('order.create');
        Route::post('/searchResult', [OrderController::class, 'searchResult'])->name('order.searchResult');
        Route::any('/store/{slug}', [OrderController::class, 'store'])->name('order.store');
        Route::get('/index', [OrderController::class, 'index'])->name('order.index');
        Route::get('/show', [OrderController::class, 'show'])->name('order.show');
        Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
        Route::any('/update/{slug}', [OrderController::class, 'update'])->name('order.update');
        Route::any('/continue/{slug}', [OrderController::class, 'continue'])->name('order.continue');
        Route::get('/destroy/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
        Route::get('/sampling/{id}', [OrderController::class, 'sampling'])->name('order.sampling');
        Route::any('/sampleUpdate/{slug}', [OrderController::class, 'sampleUpdate'])->name('order.sampleUpdate');
        Route::any('/updateStatus/{slug}', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
    });

    Route::prefix('coc')->group(function () {
        Route::get('/index', [CocController::class, 'index'])->name('coc.index');
        Route::get('/archive', [CocController::class, 'archive'])->name('coc.archive');
        Route::get('/print', [CocController::class, 'index'])->name('coc.print');
        Route::get('/show/{id}', [CocController::class, 'show'])->name('coc.show');
        Route::any('/store/{id}', [CocController::class, 'store'])->name('coc.store');
        Route::any('/destroy/{id}', [CocController::class, 'destroy'])->name('coc.destroy');
        Route::get('/Goods/{id}', [CocController::class, 'Goods'])->name('coc.Goods');
        Route::get('/editGoods/{id}', [CocController::class, 'editGoods'])->name('coc.editGoods');
        Route::any('/storeGoods/{id}', [CocController::class, 'storeGoods'])->name('coc.storeGoods');
        Route::any('/updateGoods/{id}', [CocController::class, 'updateGoods'])->name('coc.updateGoods');
        Route::any('/destroyGoods/{id}', [CocController::class, 'destroyGoods'])->name('coc.destroyGoods');
        Route::any('/changeTechnicalStatus/{id}', [CocController::class, 'changeTechnicalStatus'])->name('coc.changeTechnicalStatus');
        Route::any('/changeStatus/{id}', [CocController::class, 'changeStatus'])->name('coc.changeStatus');
        Route::get('/download-coc-goods', [CocController::class, 'downloadCocGood'])->name('download.cocGoods');
        Route::post('/upload-coc-goods/{coc}', [CocController::class, 'uploadCocGoods'])->name('upload.cocGoods');
    });

    Route::prefix('ncr')->group(function () {
        Route::get('/index', [NCRController::class, 'index'])->name('ncr.index');
        Route::get('/print', [NCRController::class, 'index'])->name('ncr.print');
        Route::get('/show/{id}', [NCRController::class, 'show'])->name('ncr.show');
        Route::any('/store/{id}', [NCRController::class, 'store'])->name('ncr.store');
        Route::any('/destroy/{id}', [NCRController::class, 'destroy'])->name('ncr.destroy');
        Route::get('/Goods/{id}', [NCRController::class, 'Goods'])->name('ncr.Goods');
        Route::get('/editGoods/{id}', [NCRController::class, 'editGoods'])->name('ncr.editGoods');
        Route::any('/storeGoods/{id}', [NCRController::class, 'storeGoods'])->name('ncr.storeGoods');
        Route::any('/updateGoods/{id}', [NCRController::class, 'updateGoods'])->name('ncr.updateGoods');
        Route::any('/destroyGoods/{id}', [NCRController::class, 'destroyGoods'])->name('ncr.destroyGoods');
        Route::any('/changeTechnicalStatus/{id}', [NCRController::class, 'changeTechnicalStatus'])->name('ncr.changeTechnicalStatus');
        Route::any('/changeStatus/{id}', [NCRController::class, 'changeStatus'])->name('ncr.changeStatus');
    });

    Route::prefix('coi')->group(function () {
        Route::get('/show/{id}', [CoiController::class, 'show'])->name('coi.show');
        Route::get('/showIC/{id}', [CoiController::class, 'showIC'])->name('coi.showIC');
        Route::get('/create/{slug?}', [CoiController::class, 'create'])->name('coi.create');
        Route::post('/searchResult', [CoiController::class, 'searchResult'])->name('coi.searchResult');
        Route::any('/store/{orderID}', [CoiController::class, 'store'])->name('coi.store');
        Route::get('/index', [CoiController::class, 'index'])->name('coi.index');
        Route::any('/storeIC/{orderID}', [CoiController::class, 'storeIC'])->name('coi.storeIC');
        Route::get('/coiGoods/{id}', [CoiController::class, 'coigoods'])->name('coi.coiGoods');
        Route::get('/icGoods/{id}', [CoiController::class, 'icGoods'])->name('coi.icGoods');
        Route::any('/goodsStore/{orderID}', [CoiController::class, 'goodsStore'])->name('coi.goodsStore');
        Route::any('/goodsUpdate/{id}', [CoiController::class, 'goodsUpdate'])->name('coi.goodsUpdate');
        Route::get('/editGoods/{id}', [CoiController::class, 'editGoods'])->name('coi.editGoods');
        Route::any('/icgoodsStore/{orderID}', [CoiController::class, 'icgoodsStore'])->name('coi.icgoodsStore');
        Route::any('/icgoodsUpdate/{id}', [CoiController::class, 'icgoodsUpdate'])->name('coi.icgoodsUpdate');
        Route::get('/iceditGoods/{id}', [CoiController::class, 'iceditGoods'])->name('coi.iceditGoods');
        Route::get('/edit/{id}', [CoiController::class, 'edit'])->name('coi.edit');
        Route::put('/update/{id}', [CoiController::class, 'update'])->name('coi.update');
        Route::get('/destroy/{id}', [CoiController::class, 'destroy'])->name('coi.destroy');
        Route::get('/destroyGoods/{id}', [CoiController::class, 'destroyGoods'])->name('coi.destroyGoods');
        Route::any('/changeStatus/{id}', [CoiController::class, 'changeStatus'])->name('coi.changeStatus');
        Route::get('/icdestroyGoodsIC/{id}', [CoiController::class, 'icdestroyGoodsIC'])->name('coi.icdestroyGoods');
        Route::any('/changeStatusIC/{id}', [CoiController::class, 'changeStatusIC'])->name('coi.changeStatusIC');
    });


    Route::prefix('ic')->group(function () {
        Route::get('/index', [CoiController::class, 'indexIC'])->name('ic.index');
    });

    Route::prefix('lc')->group(function () {
        Route::any('/index', [LcController::class, 'index'])->name('lc.index');
        Route::get('/show/{id}', [LcController::class, 'show'])->name('lc.show');
        Route::any('/update/{id}', [LcController::class, 'update'])->name('lc.update');
        Route::get('/goods/{id}', [LcController::class, 'goods'])->name('lc.goods');
        Route::any('/goodsStore/{id}', [LcController::class, 'goodsStore'])->name('lc.goodsStore');
        Route::any('/editGoods/{id}', [LcController::class, 'editGoods'])->name('lc.editGoods');
        Route::any('/updateGoods/{id}', [LcController::class, 'updateGoods'])->name('lc.updateGoods');
        Route::any('/destroyGoods/{id}', [LcController::class, 'destroyGoods'])->name('lc.destroyGoods');
        Route::any('/changeStatus/{id}', [LcController::class, 'changeStatus'])->name('lc.changeStatus');
    });
    /*
    Route::prefix('ic')->group(function() {
        Route::get('/create/{slug?}', [IcController::class, 'create'])->name('ic.create');
        Route::post('/searchResult', [IcController::class, 'searchResult'])->name('ic.searchResult');
        Route::any('/store/{slug}', [IcController::class, 'store'])->name('ic.store');
        Route::get('/index', [IcController::class, 'index'])->name('ic.index');
        Route::get('/show', [IcController::class, 'show'])->name('ic.show');
        Route::get('/edit/{id}', [IcController::class, 'edit'])->name('ic.edit');
        Route::put('/update/{id}', [IcController::class, 'update'])->name('ic.update');
        Route::get('/destroy/{id}', [IcController::class, 'destroy'])->name('ic.destroy');
    });
    */

    Route::prefix('inspection')->group(function () {
        Route::get('/show/{id}', [InspectionController::class, 'show'])->name('inspection.show');
        Route::get('/InsDoc/{id}/{category?}', [InsDocController::class, 'show'])->name('inspection.insdoc');
        Route::post('/store/{id}', [InsDocController::class, 'storeother'])->name('insdoc.storeother');
        Route::post('/storelab/{id}', [InsDocController::class, 'storelab'])->name('insdoc.storelab');
        Route::post('/storeins/{id}', [InsDocController::class, 'storeins'])->name('insdoc.storeins');
        Route::post('/storeclient/{id}', [InsDocController::class, 'storeclient'])->name('insdoc.storeclient');
    });

    Route::prefix('insdoc')->group(function () {
        Route::get('/changeStatus/{id}/{newStatus}', [InsDocController::class, 'changeStatus'])->name('insdoc.changeStatus');
        Route::get('/destroy/{id}/', [InsDocController::class, 'destroy'])->name('insdoc.destroy');
    });


    Route::prefix('bankAcceptance')->group(function () {
        Route::get('/index/{id}/', [BankAcceptanceController::class, 'index'])->name('bankAcceptance.index');
        Route::any('/update/{id}/', [BankAcceptanceController::class, 'update'])->name('bankAcceptance.update');
    });


    Route::prefix('reports')->group(function () {
        Route::get('/bankAcceptanceFormat1/{id}/', [ReportsController::class, 'bankAcceptanceFormat1'])->name('reports.bankAcceptanceFormat1');
        Route::any('/bankAcceptanceFormat2/{id}/', [ReportsController::class, 'bankAcceptanceFormat2'])->name('reports.bankAcceptanceFormat2');
        Route::any('/insOrder/{id}/', [ReportsController::class, 'insOrder'])->name('reports.insOrder');
        Route::any('/ic/{id}/{type?}/', [ReportsController::class, 'ic'])->name('reports.ic');
        Route::any('/coi/{id}/{type?}', [ReportsController::class, 'coi'])->name('reports.coi');
        Route::any('/lc/{id}/{type?}', [ReportsController::class, 'lc'])->name('reports.lc');
    });

    Route::prefix('{order}/rdocs')->name('rdocs.')->controller(ReleaseDocumentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{releaseDocument}/edit', 'edit')->name('edit');
        Route::get('/{releaseDocument}/upload', 'showUpload')->name('showUpload');
        Route::post('/{releaseDocument}/upload/certificate', 'uploadCertificate')->name('uploadCertificate');
        Route::post('/{releaseDocument}/upload/letter', 'uploadLetter')->name('uploadLetter');
        Route::post('/{releaseDocument}/upload/document', 'uploadDocument')->name('uploadDocument');

        Route::put('/{releaseDocument}', 'update')->name('update');
        Route::delete('/{releaseDocument}', 'destroy')->name('destroy');
        Route::delete('/{releaseDocument}/file', 'deleteFile')->name('deleteFile');

    });

    Route::prefix('{order}/nrdocs')->name('nrdocs.')->controller(NonReleaseDocumentController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{nonReleaseDocument}/edit', 'edit')->name('edit');
        Route::get('/{nonReleaseDocument}/upload', 'showUpload')->name('showUpload');
        Route::post('/{nonReleaseDocument}/upload/certificate', 'uploadCertificate')->name('uploadCertificate');
        Route::post('/{nonReleaseDocument}/upload/letter', 'uploadLetter')->name('uploadLetter');
        Route::post('/{nonReleaseDocument}/upload/document', 'uploadDocument')->name('uploadDocument');

        Route::put('/{nonReleaseDocument}', 'update')->name('update');
        Route::delete('/{nonReleaseDocument}', 'destroy')->name('destroy');
        Route::delete('/{nonReleaseDocument}/file', 'deleteFile')->name('deleteFile');

    });


    Route::prefix('request')->group(function() {
        Route::get('/create/{slug?}', [RequestController::class, 'create'])->name('request.create');
        Route::get('/createrft/{slug?}', [RequestController::class, 'createrft'])->name('request.createrft');
        Route::post('/searchResult', [RequestController::class, 'searchResult'])->name('request.searchResult');
        Route::any('/store/{slug}', [RequestController::class, 'store'])->name('request.store');
        Route::get('/index/{type?}/{status?}', [RequestController::class, 'index'])->name('request.index');
        Route::get('/showrfc/{id}', [RequestController::class, 'showrfc'])->name('request.showrfc');
        Route::get('/showrft/{id}', [RequestController::class, 'showrft'])->name('request.showrft');
        Route::get('/edit/{id}', [RequestController::class, 'edit'])->name('request.edit');
        Route::any('/update/{slug}', [RequestController::class, 'update'])->name('request.update');
        Route::any('/continue/{slug}', [RequestController::class, 'continue'])->name('request.continue');
        Route::get('/destroy/{id}', [RequestController::class, 'destroy'])->name('request.destroy');
    });


    Route::prefix('rft')->group(function() {
        Route::get('/create/{slug?}', [RftController::class, 'create'])->name('rft.create');
        Route::get('/createrft/{slug?}', [RftController::class, 'createrft'])->name('rft.createrft');
        Route::post('/searchResult', [RftController::class, 'searchResult'])->name('rft.searchResult');
        Route::any('/store/{slug}', [RftController::class, 'store'])->name('rft.store');
        Route::get('/index/{slug}', [RftController::class, 'index'])->name('rft.index');
        Route::get('/show', [RftController::class, 'show'])->name('rft.show');
        Route::get('/edit/{id}', [RftController::class, 'edit'])->name('rft.edit');
        Route::any('/update/{slug}', [RftController::class, 'update'])->name('rft.update');
        Route::any('/continue/{slug}', [RftController::class, 'continue'])->name('rft.continue');
        Route::get('/destroy/{id}', [RftController::class, 'destroy'])->name('rft.destroy');
        Route::get('/rftsamples/{id}', [RftController::class, 'samples'])->name('rft.samples');
        Route::any('/storeSamples/{slug}', [RftController::class, 'storeSamples'])->name('rft.storeSamples');
        Route::get('/destroySample/{id}', [RftController::class, 'destroySample'])->name('rft.destroySample');
        Route::get('/editSample/{id}', [RftController::class, 'editSample'])->name('rft.editSample');
        Route::any('/updateSample/{slug}', [RftController::class, 'updateSample'])->name('rft.updateSample');
        Route::any('/changeStatus/{id}', [RftController::class, 'changeStatus'])->name('rft.changeStatus');
        Route::post('/upload/{rft}', [RftController::class, 'uploadTestReport'])->name('rft.uploadTestReport');
        Route::delete('/destroy/{rft}', [RftController::class, 'destroyTestReport'])->name('rft.destroyTestReport');
    });

    Route::get('/labfees/search', [LabFeeController::class, 'search'])->name('labfees.search');

});

Route::prefix('words')->name('words.')->controller(WordController::class)->group(function () {
    Route::get('/coc/{coc}', 'generateDocumentCoc')->name('coc')->middleware('signed');
    Route::get('/ncr/{ncr}', 'generateDocumentNcr')->name('ncr')->middleware('signed');
    Route::get('/rd/{releaseDocument}', 'generateDocumentRelease')->name('rd')->middleware('signed');
    Route::get('/nrd/{nonReleaseDocument}', 'generateDocumentNonRelease')->name('nrd')->middleware('signed');
    Route::get('/sample/{order}', 'generateSample')->name('sample')->middleware('signed');
});
