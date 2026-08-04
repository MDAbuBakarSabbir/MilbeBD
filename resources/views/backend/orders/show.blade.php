@extends('layouts.backend.masterLay')
@section('title', 'Order Invoice - ' . $order->order_id)
@section('content')
<style>
    .invoice-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        padding: 40px;
        max-width: 850px;
        margin: auto;
    }
    .invoice-header {
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 25px;
        margin-bottom: 30px;
    }
    .invoice-meta-label {
        font-size: 11px;
        text-transform: uppercase;
        color: #64748b;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .invoice-meta-val {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }
    .table-invoice th {
        background: #f8fafc;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        border: none;
        padding: 14px;
    }
    .table-invoice td {
        padding: 16px 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        font-weight: 500;
        color: #1e293b;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        .invoice-card, .invoice-card * {
            visibility: visible;
        }
        .invoice-card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none;
            padding: 20px;
        }
        .no-print {
            display: none !important;
        }
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-3 d-flex justify-content-between align-items-center no-print">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary"><i class="mdi mdi-arrow-left mr-1"></i> Back to Orders</a>
            <div>
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-primary mr-2"><i class="mdi mdi-pencil mr-1"></i> Edit Order</a>
                <button onclick="window.print()" class="btn btn-sm btn-success"><i class="mdi mdi-printer mr-1"></i> Print Invoice</button>
            </div>
        </div>

        <div class="invoice-card">
            <!-- Header -->
            <div class="invoice-header d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="font-weight-bold text-primary mb-1">MILBE <span class="text-dark">BD</span></h3>
                    <p class="text-muted mb-0" style="font-size: 13px;">Gulshan, Dhaka, Bangladesh<br>Phone: +880 1234-567890<br>Email: support@milbebd.com</p>
                </div>
                <div class="text-right">
                    <h4 class="font-weight-bold text-dark mb-1">INVOICE</h4>
                    <div class="badge badge-primary px-3 py-1 mb-2">{{ $order->order_status }}</div>
                    <div class="invoice-meta-label">Order Reference</div>
                    <div class="invoice-meta-val text-primary">{{ $order->order_id }}</div>
                    <div class="invoice-meta-label mt-2">Date</div>
                    <div class="invoice-meta-val">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</div>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="row mb-4">
                <div class="col-sm-6">
                    <div class="p-3 bg-light rounded">
                        <div class="invoice-meta-label mb-1">Billed To (Customer)</div>
                        <h6 class="font-weight-bold text-dark mb-1">{{ $order->customer_name }}</h6>
                        <p class="mb-1 text-muted" style="font-size: 13px;"><i class="mdi mdi-phone mr-1"></i> {{ $order->customer_phone }}</p>
                        <p class="mb-0 text-muted" style="font-size: 13px;"><i class="mdi mdi-map-marker mr-1"></i> {{ $order->customer_address }}, {{ $order->customer_district }}</p>
                    </div>
                </div>
                <div class="col-sm-6 mt-3 mt-sm-0">
                    <div class="p-3 bg-light rounded h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="invoice-meta-label mb-1">Payment Method</div>
                            <h6 class="font-weight-bold text-dark mb-1">{{ $order->payment_method }}</h6>
                            @if($order->transaction_id)
                                <p class="mb-0 text-muted" style="font-size: 13px;">Transaction ID: <strong>{{ $order->transaction_id }}</strong></p>
                            @endif
                        </div>
                        <div class="mt-2">
                            <div class="invoice-meta-label">Courier History / Notes</div>
                            <p class="mb-0 text-muted" style="font-size: 13px;">{{ $order->courier_history ?: 'Standard processing' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item Table -->
            <div class="table-responsive mb-4">
                <table class="table table-invoice m-0">
                    <thead>
                        <tr>
                            <th>Item Description</th>
                            <th class="text-center">Color/Variant</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="font-weight-bold text-dark">{{ $order->product_id }}</div>
                                <small class="text-muted">Premium lifestyle and technical item</small>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-light border">{{ $order->product_color }}</span>
                            </td>
                            <td class="text-center font-weight-bold">{{ $order->product_quantity }}</td>
                            <td class="text-right font-weight-bold text-dark">৳ {{ number_format(floatval($order->order_sub_total), 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Summary Totals -->
            <div class="row justify-content-end">
                <div class="col-md-6 col-lg-5">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted font-weight-semibold">Subtotal:</span>
                        <span class="font-weight-bold text-dark">৳ {{ number_format(floatval($order->order_sub_total), 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted font-weight-semibold">Delivery Charge ({{ $order->customer_district }}):</span>
                        <span class="font-weight-bold text-dark">৳ {{ number_format(floatval($order->delivery_cost), 2) }}</span>
                    </div>
                    @if(floatval($order->coupon_discount) > 0 || floatval($order->admin_discount) > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span class="font-weight-semibold">Discount:</span>
                        <span class="font-weight-bold">- ৳ {{ number_format(floatval($order->coupon_discount) + floatval($order->admin_discount), 2) }}</span>
                    </div>
                    @endif
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h6 font-weight-bold text-dark m-0">Grand Total:</span>
                        <span class="h4 font-weight-bold text-primary m-0">৳ {{ number_format(floatval($order->grand_total), 2) }}</span>
                    </div>
                </div>
            </div>

            <hr class="my-4">
            <div class="text-center text-muted" style="font-size: 12px;">
                Thank you for shopping with MilbeBD! For support, contact support@milbebd.com or +880 1234-567890.
            </div>
        </div>
    </div>
</div>
@endsection
