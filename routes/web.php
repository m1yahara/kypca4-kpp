<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TrailerController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\TruckMileageController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\RouteController;

Auth::routes();


Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::resource('/orders', OrderController::class)->middleware('auth');

Route::resource('trucks', TruckController::class)->middleware('auth');

Route::resource('trailers', TrailerController::class)->middleware('auth');

Route::prefix('trucks/{truck}/mileage')->middleware('auth')->group(function () {
    Route::get('/', [TruckMileageController::class, 'index'])->name('truck_mileages.index');
    Route::get('/create', [TruckMileageController::class, 'create'])->name('truck_mileages.create');
    Route::post('/', [TruckMileageController::class, 'store'])->name('truck_mileages.store');
    Route::get('/{mileage}/edit', [TruckMileageController::class, 'edit'])->name('truck_mileages.edit');
    Route::put('/{mileage}', [TruckMileageController::class, 'update'])->name('truck_mileages.update');
    Route::delete('/{mileage}', [TruckMileageController::class, 'destroy'])->name('truck_mileages.destroy');
});

Route::get('/finances', [FinanceController::class, 'index'])->name('finance.index')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/work-act/{orderId}', [DocumentController::class, 'generateWorkAct'])->name('documents.work_act');
    Route::get('/income-report', [DocumentController::class, 'generateIncomeReportPdf'])->name('documents.incomeReportPdf');
    Route::get('/expense-report', [DocumentController::class, 'generateExpenseReportPdf'])->name('documents.expenseReportPdf');
    Route::get('/financial-report', [DocumentController::class, 'generateFinancialReportPdf'])->name('documents.financialReportPdf');
    Route::get('/mileage-history/{truckId}', [DocumentController::class, 'generateMileageHistory'])->name('documents.mileage_history');
    Route::get('/all-orders', [DocumentController::class, 'generateAllOrders'])->name('documents.all_orders');
    Route::get('/user-fleet', [DocumentController::class, 'generateUserFleet'])->name('documents.user_fleet');
    Route::get('/documents', [DocumentController::class, 'showDocumentOptions'])->name('documents.options');
});

Route::middleware('auth')->group(function () {
    Route::get('/routes', [RouteController::class, 'index'])->name('routes');
    Route::post('/route', [RouteController::class, 'calculateRoute'])->name('calculate.route');
    Route::get('/my-routes', [RouteController::class, 'showRoutes'])->name('my.routes');
    Route::delete('/routes/{id}', [RouteController::class, 'deleteRoute'])->name('delete.route');
    Route::get('/routes/{id}', [RouteController::class, 'getRoute'])->name('get.route');
    Route::post('/route/save', [RouteController::class, 'saveRoute'])->name('save.route');
});

