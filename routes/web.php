<?php

use App\Http\Controllers\BlockedIpController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\SystemAPIController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Helper routes for server deployment
Route::get('/optimize-clear', function() {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Optimize Cleared. <a href="/">Go to Home</a>';
});

Route::get('/migrate-force', function() {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    return 'Migration Done. <a href="/">Go to Home</a>';
});

// ------------------------------------------Frontend Routes Section----------------------------

Route::controller(PagesController::class)->group(function () {
    Route::get('page/{slug}', 'showPage')->name('front.page');
});

// ------------------------------------------Admin Routes Section----------------------------

Auth::routes();

Route::controller(PagesController::class)->group(function () {
    Route::get('admin/pages', 'index')->name('admin.pages.index');
    Route::get('admin/pages/create', 'create')->name('admin.pages.create');
    Route::post('admin/pages', 'store')->name('admin.pages.store');
    Route::get('admin/pages/{id}/edit', 'edit')->name('admin.pages.edit');
    Route::put('admin/pages/{id}', 'update')->name('admin.pages.update');
    Route::delete('admin/pages/{id}', 'destroy')->name('admin.pages.destroy');
    Route::post('admin/pages/status', 'status')->name('admin.pages.status');
});

Route::controller(OrdersController::class)->group(function () {
    Route::get('admin/orders', 'index')->name('admin.orders.index');
    Route::get('admin/orders/status/{id}', 'statusIndex')->name('admin.orders.status');
    Route::get('admin/orders/create', 'create')->name('admin.orders.create');
    Route::post('admin/orders', 'adminStore')->name('admin.orders.store');
    Route::post('admin/orders/steadfast-bulk', 'sendToSteadfastBulk')->name('admin.orders.steadfast.bulk');
    Route::get('admin/orders/{id}', 'show')->name('admin.orders.show');
    Route::get('admin/orders/{id}/edit', 'edit')->name('admin.orders.edit');
    Route::put('admin/orders/{id}', 'update')->name('admin.orders.update');
    Route::delete('admin/orders/{id}', 'destroy')->name('admin.orders.destroy');
    Route::get('admin/incomplete-orders', 'incompleteView')->name('admin.incomplete.view');
});

Route::controller(BlockedIpController::class)->group(function () {
    Route::post('admin/ip-block', 'store')->name('ip_block.store');
    Route::delete('admin/ip-block/{id}', 'destroy')->name('ip_block.destroy');
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

Route::controller(HomeController::class)->group(function () {
    Route::get('/admin/dashboard', 'index')->name('dashboard');
    Route::get('/admin/site-settings', 'siteSettings')->name('admin.siteSettings');
    Route::post('/site-info-update', 'siteInfoUpdate')->name('admin.siteInfoUpdate');
    Route::post('/site-header-logo-update', 'siteHeaderLogoUpdate')->name('admin.siteHeaderLogoUpdate');
    Route::post('/site-footer-logo-update', 'siteFooterLogoUpdate')->name('admin.siteFooterLogoUpdate');
    Route::post('/site-favicon-update', 'siteFaviconUpdate')->name('admin.siteFaviconUpdate');
    Route::post('/pixel-gtag-update', 'pixelGtagUpdate')->name('admin.pixelGtagUpdate');
});

Route::controller(ReviewsController::class)->group(function () {
    Route::get('admin/reviews', 'index')->name('admin.reviews.index');
    Route::post('admin/reviews', 'store')->name('admin.reviews.store');
    Route::get('admin/reviews/{id}/edit', 'edit')->name('admin.reviews.edit');
    Route::put('admin/reviews/{id}', 'update')->name('admin.reviews.update');
    Route::delete('admin/reviews/{id}', 'destroy')->name('admin.reviews.destroy');
    Route::post('admin/reviews/status', 'status')->name('admin.reviews.status');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('admin/product', 'index')->name('admin.product.index');
    Route::post('admin/product', 'store')->name('admin.product.store');
});
