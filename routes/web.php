<?php

use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\SystemAPIController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ------------------------------------------Frontend Routes Section----------------------------

Route::controller(FrontendController::class)->group(function () {});

// ------------------------------------------Admin Routes Section----------------------------

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::controller(OrdersController::class)->group(function () {
    Route::get('admin/orders', 'index')->name('admin.orders.index');
    Route::get('admin/orders/create', 'create')->name('admin.orders.create');
    Route::get('admin/pos', 'pos')->name('admin.pos.index');
    Route::post('admin/orders', 'adminStore')->name('admin.orders.store');
    Route::get('admin/orders/{id}', 'show')->name('admin.orders.show');
    Route::get('admin/orders/{id}/edit', 'edit')->name('admin.orders.edit');
    Route::put('admin/orders/{id}', 'update')->name('admin.orders.update');
    Route::delete('admin/orders/{id}', 'destroy')->name('admin.orders.destroy');
    Route::get('admin/incomplete-orders', 'incompleteView')->name('admin.incomplete.view');
});
Route::controller(OrdersController::class)->group(function () {
    Route::post('orders', 'store')->name('orders.store');
    Route::get('order-success', 'orderSuccess')->name('order.success');
    Route::post('orders/incomplete', 'incompleteStore')->name('orders.incompleteStore');
});

Route::controller(SystemAPIController::class)->group(function () {
    Route::get('/courier-apis', 'courier_api')->name('courier-apis.index');
    Route::get('/courier-apis/create', 'courier_api_create')->name('courier-apis.create');
    Route::post('/courier-apis/store', 'courier_api_store')->name('courier-apis.store');
    Route::post('/courier-apis/update', 'courier_api_update')->name('courier-apis.update');
    Route::delete('/courier-apis/{id}', 'destroy')->name('courier-apis.destroy');

    Route::get('/fraud-checkers', 'fraud_api')->name('fraud-checkers.index');
    Route::get('/fraud-checkers/create', 'fraud_api_create')->name('fraud-checkers.create');
    Route::post('/fraud-checkers/store', 'fraud_api_store')->name('fraud-checkers.store');
    Route::get('/fraud-checkers/update', 'fraud_api_update')->name('fraud-checkers.update');
    Route::delete('/fraud-checkers/{id}', 'destroy')->name('fraud-checkers.destroy');
});

Route::controller(OrderStatusController::class)->group(function () {
    Route::get('admin/order-status', 'index')->name('admin.orderStatus.index');
    Route::post('admin/order-status', 'store')->name('admin.orderStatus.store');
    Route::get('admin/order-status/{id}/edit', 'edit')->name('admin.orderStatus.edit');
    Route::put('admin/order-status/{id}', 'update')->name('admin.orderStatus.update');
    Route::delete('admin/order-status/{id}', 'destroy')->name('admin.orderStatus.destroy');
});
Route::controller(DistrictController::class)->group(function () {
    Route::get('admin/districts', 'index')->name('admin.districts.index');
    Route::post('admin/districts', 'store')->name('admin.districts.store');
    Route::get('admin/districts/{id}/edit', 'edit')->name('admin.districts.edit');
    Route::put('admin/districts/{id}', 'update')->name('admin.districts.update');
    Route::delete('admin/districts/{id}', 'destroy')->name('admin.districts.destroy');
});
