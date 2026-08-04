@extends('layouts.backend.masterLay')
@section('title','ORDERS')
@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">Filter</div>
                <div class="card-body">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">Order Lists</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Order ID</th>
                                    <th>Customer Details</th>
                                    <th>Product details</th>
                                    <th>Order Amount</th>
                                    <th>Order Status</th>
                                    <th>Comment</th>
                                    <th>Order Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td><input type="checkbox" name="selected_orders[]" value="{{ $order->id }}" class="order-checkbox"></td>
                                        <td class="font-weight-bold text-primary">{{ $order->order_id }}</td>
                                        <td>
                                            <strong class="text-dark">{{ $order->customer_name }}</strong><br>
                                            <span class="text-muted"><i class="mdi mdi-phone mr-1"></i> {{ $order->customer_phone }}</span><br>
                                            <small class="text-muted">{{ $order->customer_address }}, {{ $order->customer_district }}</small>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">{{ $order->product_id }}</div>
                                            <small class="text-muted">Color/Variant: {{ $order->product_color }} | Qty: {{ $order->product_quantity }}</small>
                                        </td>
                                        <td>
                                            <strong>Grand Total: ৳ {{ number_format(floatval($order->grand_total), 2) }}</strong><br>
                                            <small class="text-muted">Subtotal: ৳ {{ number_format(floatval($order->order_sub_total), 2) }}</small><br>
                                            <small class="text-muted">Delivery: ৳ {{ number_format(floatval($order->delivery_cost), 2) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-primary px-2 py-1 mb-1">{{ $order->order_status }}</span><br>
                                            <small class="text-muted d-block">Via: {{ $order->payment_method }}</small>
                                            <small class="text-muted d-block">{{ $order->created_at ? $order->created_at->format('M d, Y H:i') : 'N/A' }}</small>
                                        </td>
                                        <td>{{ $order->courier_history ?: 'N/A' }}</td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm mr-1" title="View Details"><i class="mdi mdi-eye"></i></a>
                                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary btn-sm mr-1" title="Edit"><i class="mdi mdi-pencil"></i></a>
                                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete order {{ $order->order_id }}?');" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="mdi mdi-delete"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="mdi mdi-shopping text-muted" style="font-size: 40px;"></i>
                                            <p class="mt-2 font-weight-bold">No orders found.</p>
                                            <a href="{{ route('admin.pos.index') }}" class="btn btn-sm btn-primary mt-1">Open POS Terminal</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection