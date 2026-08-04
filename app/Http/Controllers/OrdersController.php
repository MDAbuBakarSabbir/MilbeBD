<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Orders;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Customer Order Function (Public Checkout Submission)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
        ]);

        $orderId = 'MBD-' . rand(100000, 999999);
        $qty = intval($request->product_qty ?: 1);
        $price = floatval($request->product_price ?: 199);
        $subTotal = $price * $qty;
        $deliveryCost = floatval($request->delivery_cost ?: 0);
        $grandTotal = floatval($request->total_amount ?: ($subTotal + $deliveryCost));

        $order = Orders::create([
            'customer_name' => $request->name,
            'customer_phone' => $request->phone,
            'customer_address' => $request->address,
            'customer_district' => $request->city,
            'order_id' => $orderId,
            'payment_method' => $request->payment_method ?? 'Cash on Delivery',
            'transaction_id' => $request->transaction_id ?? null,
            'order_date' => now()->format('Y-m-d H:i:s'),
            'product_id' => $request->product_name ?: 'Milbe Sound Pro Headphones',
            'product_color' => $request->product_color ?: 'Standard',
            'product_quantity' => strval($qty),
            'order_sub_total' => strval($subTotal),
            'delivery_cost' => strval($deliveryCost),
            'coupon_code' => $request->coupon_code ?? null,
            'coupon_discount' => $request->coupon_discount ?? '0',
            'admin_discount' => $request->admin_discount ?? '0',
            'grand_total' => strval($grandTotal),
            'order_status' => 'Pending',
            'courier_history' => 'Order received from website checkout.',
        ]);

        session()->put('last_order', $order);

        return redirect()->route('order.success')->with('success', 'Your order has been placed successfully!');
    }

    /**
     * Order Confirmation Receipt Screen
     */
    public function orderSuccess()
    {
        $order = session('last_order');
        if (!$order) {
            $order = Orders::latest()->first();
        }

        if (!$order) {
            return redirect('/');
        }

        return view('success', compact('order'));
    }

    /**
     * Point of Sale (POS) Interface for Admin
     */
    public function pos()
    {
        $products = Product::latest()->get();
        $districts = District::where('status', '1')->get();
        $orderStatuses = OrderStatus::all();

        return view('backend.orders.pos', compact('products', 'districts', 'orderStatuses'));
    }

    /**
     * Admin & POS Order Submission
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
        ]);

        $orderId = 'POS-' . rand(100000, 999999);
        $subTotal = floatval($request->order_sub_total ?: 0);
        $deliveryCost = floatval($request->delivery_cost ?: 0);
        $discount = floatval($request->discount ?: 0);
        $grandTotal = floatval($request->grand_total ?: ($subTotal + $deliveryCost - $discount));

        $order = Orders::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'customer_district' => $request->customer_city ?? ($request->customer_district ?? 'Dhaka'),
            'order_id' => $orderId,
            'payment_method' => $request->payment_method ?? 'POS Cash',
            'transaction_id' => $request->transaction_id ?? null,
            'order_date' => now()->format('Y-m-d H:i:s'),
            'product_id' => $request->product_items ?? ($request->product_name ?? 'POS Custom Item'),
            'product_color' => $request->product_color ?? 'N/A',
            'product_quantity' => strval($request->product_quantity ?? 1),
            'order_sub_total' => strval($subTotal),
            'delivery_cost' => strval($deliveryCost),
            'coupon_code' => $request->coupon_code ?? null,
            'coupon_discount' => strval($discount),
            'admin_discount' => '0',
            'grand_total' => strval($grandTotal),
            'order_status' => $request->order_status ?? 'Approved',
            'courier_history' => 'Processed via Admin POS interface.',
        ]);

        return redirect()->route('admin.orders.index')->with('success', "Order #{$orderId} created successfully via POS!");
    }

    /**
     * Admin Order Lists
     */
    public function index()
    {
        $orders = Orders::latest()->get();
        return view('backend.orders.index', compact('orders'));
    }

    /**
     * Admin Create Order View
     */
    public function create()
    {
        return view('backend.orders.create');
    }

    /**
     * Show Order Details
     */
    public function show($id)
    {
        $order = Orders::findOrFail($id);
        return view('backend.orders.show', compact('order'));
    }

    /**
     * Edit Order View
     */
    public function edit($id)
    {
        $order = Orders::findOrFail($id);
        return view('backend.orders.edit', compact('order'));
    }

    /**
     * Update Order
     */
    public function update(Request $request, $id)
    {
        $order = Orders::findOrFail($id);
        
        $order->update($request->except(['_token', '_method']));

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Delete Order
     */
    public function destroy($id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }

    /**
     * Incomplete Orders View
     */
    public function incompleteView()
    {
        $orders = Orders::where('order_status', 'Incomplete')->latest()->get();
        return view('backend.orders.incomplete', compact('orders'));
    }

    /**
     * Incomplete Order Submission (e.g. tracking partial form fill)
     */
    public function incompleteStore(Request $request)
    {
        if (!$request->phone && !$request->name) {
            return response()->json(['status' => 'error', 'message' => 'Insufficient data']);
        }

        $orderId = 'INC-' . rand(100000, 999999);

        $order = Orders::create([
            'customer_name' => $request->name ?? 'Incomplete Lead',
            'customer_phone' => $request->phone ?? 'N/A',
            'customer_address' => $request->address ?? 'N/A',
            'customer_district' => $request->city ?? 'N/A',
            'order_id' => $orderId,
            'payment_method' => 'Pending',
            'order_date' => now()->format('Y-m-d H:i:s'),
            'product_id' => $request->product_name ?? 'Milbe Sound Pro Headphones',
            'product_color' => $request->product_color ?? 'Standard',
            'product_quantity' => strval($request->product_qty ?? 1),
            'order_sub_total' => strval($request->product_price ?? 0),
            'delivery_cost' => '0',
            'grand_total' => strval($request->total_amount ?? 0),
            'order_status' => 'Incomplete',
            'courier_history' => 'Incomplete checkout lead.',
        ]);

        return response()->json(['status' => 'success', 'order_id' => $orderId]);
    }
}
