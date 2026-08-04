<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_address');
            $table->string('customer_district');
            $table->string('order_id');
            $table->string('payment_method');
            $table->string('transaction_id')->nullable();
            $table->string('order_date');
            $table->string('product_id');
            $table->string('product_color');
            $table->string('product_quantity');
            $table->string('order_sub_total');
            $table->string('delivery_cost');
            $table->string('coupon_code')->nullable();
            $table->string('coupon_discount')->nullable();
            $table->string('admin_discount')->nullable();
            $table->string('grand_total');
            $table->string('order_status')->default('Pending');
            $table->string('courier_history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
