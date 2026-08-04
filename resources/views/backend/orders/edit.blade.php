@extends('layouts.backend.masterLay')
@section('title','Edit Order: ' . $order->order_id)
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" style="border-radius: 16px 16px 0 0;">
                    <h5 class="mb-0 text-white"><i class="mdi mdi-pencil mr-2"></i> Edit Order Details - {{ $order->order_id }}</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-light"><i class="mdi mdi-arrow-left"></i> Back</a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">Customer Name</label>
                                <input type="text" name="customer_name" class="form-control" value="{{ $order->customer_name }}" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">Phone Number</label>
                                <input type="text" name="customer_phone" class="form-control" value="{{ $order->customer_phone }}" required>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Delivery Address</label>
                            <textarea name="customer_address" class="form-control" rows="2" required>{{ $order->customer_address }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">District / City</label>
                                <input type="text" name="customer_district" class="form-control" value="{{ $order->customer_district }}">
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-bold">Order Status</label>
                                <select name="order_status" class="form-control font-weight-bold">
                                    <option value="{{ $order->order_status }}" selected>{{ $order->order_status }} (Current)</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                    @if(isset($orderStatus))
                                        @foreach($orderStatus as $os)
                                            <option value="{{ $os->name }}">{{ $os->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold">Payment Method</label>
                                <input type="text" name="payment_method" class="form-control" value="{{ $order->payment_method }}">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold">Delivery Fee (৳)</label>
                                <input type="number" step="0.01" name="delivery_cost" class="form-control" value="{{ $order->delivery_cost }}">
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="font-weight-bold">Grand Total (৳)</label>
                                <input type="number" step="0.01" name="grand_total" class="form-control font-weight-bold text-primary" value="{{ $order->grand_total }}">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label class="font-weight-bold">Courier & Admin Notes</label>
                            <textarea name="courier_history" class="form-control" rows="2">{{ $order->courier_history }}</textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold"><i class="mdi mdi-content-save mr-1"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection