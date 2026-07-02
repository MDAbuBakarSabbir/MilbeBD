@extends('layouts.backend.masterLay')
@section('title', 'Create Order')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        margin-bottom: 25px;
    }
    .modern-input {
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 12px 15px;
        font-size: 14px;
        transition: 0.3s;
        background-color: #f8fafc;
    }
    .modern-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        background-color: #fff;
    }
    .modern-label {
        font-weight: 600;
        color: #4a5568;
        font-size: 13px;
        margin-bottom: 8px;
    }
    .modern-table thead th {
        border-top: none;
        border-bottom: 2px solid #f4f5f9;
        color: #8f9fc2;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
    }
    .modern-table tbody td {
        vertical-align: middle;
        border-bottom: 1px solid #f4f5f9;
        color: #2d3748;
        font-weight: 500;
        padding: 15px 10px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed #e2e8f0;
        font-weight: 600;
        color: #4a5568;
    }
    .summary-row.total {
        font-size: 18px;
        color: #2d3748;
        border-bottom: none;
        padding-top: 15px;
        font-weight: 800;
    }
    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 12px 25px;
        font-weight: 600;
        font-size: 15px;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(102,126,234,0.3);
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102,126,234,0.4);
        color: #fff;
    }
    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
        display: flex;
        align-items: center;
    }
    .section-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 18px;
    }
</style>

<form action="{{ route('admin.orders.store') }}" method="POST">
    @csrf
    <div class="row">
        <!-- Customer Information -->
        <div class="col-xl-4 col-lg-5">
            <div class="card glass-card">
                <div class="card-header border-0 pb-0 pt-4 px-4 bg-transparent">
                    <h4 class="section-title">
                        <div class="section-icon shadow-sm" style="background: #e3f2fd; color: #2196f3;">
                            <i class="mdi mdi-account"></i>
                        </div>
                        Customer Information
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="form-group mb-4">
                        <label class="modern-label">Customer Name <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control modern-input" placeholder="e.g. John Doe" required>
                    </div>
                    <div class="form-group mb-4">
                        <label class="modern-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="customer_phone" class="form-control modern-input" placeholder="e.g. 01XXXXXXXXX" required>
                    </div>
                    <div class="form-group mb-4">
                        <label class="modern-label">Delivery Address <span class="text-danger">*</span></label>
                        <textarea name="customer_address" class="form-control modern-input" rows="3" placeholder="Full detailed address" required></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="modern-label">City / District <span class="text-danger">*</span></label>
                        <input type="text" name="customer_city" class="form-control modern-input" placeholder="e.g. Dhaka" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product & Summary -->
        <div class="col-xl-8 col-lg-7">
            <!-- Product Information -->
            <div class="card glass-card">
                <div class="card-header border-0 pb-0 pt-4 px-4 bg-transparent d-flex justify-content-between align-items-center">
                    <h4 class="section-title">
                        <div class="section-icon shadow-sm" style="background: #e6f8f0; color: #10c469;">
                            <i class="mdi mdi-package-variant-closed"></i>
                        </div>
                        Product Information
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="search mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-0" style="border-radius: 12px 0 0 12px;"><i class="mdi mdi-magnify text-muted"></i></span>
                            </div>
                            <input type="text" id="productSearch" class="form-control modern-input border-0 bg-light" style="border-radius: 0 12px 12px 0;" placeholder="Search and add products...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table modern-table table-borderless m-0">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">Image</th>
                                    <th>Product Details</th>
                                    <th class="text-center" style="width: 120px;">Price</th>
                                    <th class="text-center" style="width: 100px;">Qty</th>
                                    <th class="text-right" style="width: 120px;">Total</th>
                                    <th style="width: 50px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example Row (Ideally populated by JS) -->
                                <tr>
                                    <td>
                                        <div style="width: 45px; height: 45px; border-radius: 10px; background: #f4f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                            <i class="mdi mdi-image text-muted" style="font-size: 20px;"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-dark">Example Product Name</div>
                                        <div class="text-muted" style="font-size: 12px;">SKU: PROD-123</div>
                                    </td>
                                    <td class="text-center">৳ 500</td>
                                    <td>
                                        <input type="number" class="form-control modern-input px-2 text-center" value="2" min="1" style="height: 35px; padding: 5px;">
                                    </td>
                                    <td class="text-right font-weight-bold text-primary">৳ 1,000</td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-sm btn-light text-danger shadow-sm" style="border-radius: 10px;"><i class="mdi mdi-delete"></i></button>
                                    </td>
                                </tr>
                                <!-- Empty state when no products added
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="mdi mdi-cart-outline" style="font-size: 48px; color: #cbd5e1;"></i>
                                        <p class="mt-2 font-weight-bold">No products added yet.</p>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card glass-card">
                <div class="card-header border-0 pb-0 pt-4 px-4 bg-transparent">
                    <h4 class="section-title">
                        <div class="section-icon shadow-sm" style="background: #fff4e5; color: #ff9800;">
                            <i class="mdi mdi-receipt"></i>
                        </div>
                        Order Summary
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group mb-4">
                                        <label class="modern-label">Payment Method</label>
                                        <select name="payment_method" class="form-control modern-input">
                                            <option value="cash_on_delivery">Cash on Delivery</option>
                                            <option value="bkash">Bkash</option>
                                            <option value="nagad">Nagad</option>
                                            <option value="rocket">Rocket</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group mb-4">
                                        <label class="modern-label">Payment Status</label>
                                        <select name="payment_status" class="form-control modern-input">
                                            <option value="unpaid">Unpaid</option>
                                            <option value="paid">Paid</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label class="modern-label">Order Notes (Optional)</label>
                                <textarea name="order_notes" class="form-control modern-input" rows="2" placeholder="Any special instructions..."></textarea>
                            </div>
                        </div>
                        <div class="col-md-5 mt-4 mt-md-0">
                            <div class="p-4" style="background: #f8fafc; border-radius: 15px;">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span>৳ 1,000</span>
                                </div>
                                <div class="summary-row">
                                    <span>Delivery Charge</span>
                                    <span>৳ 120</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total Amount</span>
                                    <span class="text-primary">৳ 1,120</span>
                                </div>
                                <button type="submit" class="btn btn-gradient btn-block mt-4">
                                    <i class="mdi mdi-check-circle-outline mr-1"></i> Confirm Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection