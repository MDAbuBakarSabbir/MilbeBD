<?php

namespace App\Providers;

use App\Models\OrderStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.backend.masterLay', function ($view) {
            if (Schema::hasTable('order_statuses')) {
                $view->with('orderStatus', OrderStatus::all());
            } else {
                $view->with('orderStatus', collect());
            }
        });
    }
}
