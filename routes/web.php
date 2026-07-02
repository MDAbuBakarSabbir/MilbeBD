<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SystemAPIController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::controller(OrdersController::class)->group(function () {
    Route::get('admin/orders', 'index')->name('admin.orders.index');
    Route::get('admin/orders/create', 'create')->name('admin.orders.create');
    Route::post('admin/orders', 'adminStore')->name('admin.orders.store');
    Route::get('admin/orders/{id}', 'show')->name('admin.orders.show');
    Route::get('admin/orders/{id}/edit', 'edit')->name('admin.orders.edit');
    Route::put('admin/orders/{id}', 'update')->name('admin.orders.update');
    Route::delete('admin/orders/{id}', 'destroy')->name('admin.orders.destroy');
    Route::get('admin/incomplete-orders', 'incompleteView')->name('admin.incomplete.view');
});
Route::controller(OrdersController::class)->group(function () {
    Route::post('orders', 'store')->name('orders.store');
    Route::post('orders/incomplete', 'incompleteStore')->name('orders.incompleteStore');
});

Route::controller(SystemAPIController::class)->group(function () {
    Route::get('/courier-apis', 'index')->name('courier-apis.index');
    Route::post('/courier-apis/update', 'update')->name('courier-apis.update');
    Route::delete('/courier-apis/{id}', 'destroy')->name('courier-apis.destroy');

    Route::get('/sms-apis', 'create')->name('sms-apis.create');
    Route::post('/sms-apis/update', 'update')->name('sms-apis.update');
    Route::delete('/sms-apis/{id}', 'destroy')->name('sms-apis.destroy');

    Route::get('/payment-gateways', 'create')->name('payment-gateways.create');
    Route::post('/payment-gateways/update', 'update')->name('payment-gateways.update');
    Route::delete('/payment-gateways/{id}', 'destroy')->name('payment-gateways.destroy');

    Route::get('/fraud-checkers', 'create')->name('fraud-checkers.create');
    Route::post('/fraud-checkers/update', 'update')->name('fraud-checkers.update');
    Route::delete('/fraud-checkers/{id}', 'destroy')->name('fraud-checkers.destroy');
});
