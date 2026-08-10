<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderStatus;
use App\Models\SystemAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        // Courier History
        $courierHistory = '';
        $bdCourierApi = SystemAPI::where('api_name', 'BD Courier API')->first();

        if ($bdCourierApi && $bdCourierApi->api_status === 'Active' && ! empty($bdCourierApi->api_key)) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '.$bdCourierApi->api_key,
                    'Content-Type' => 'application/json',
                ])->post('https://api.bdcourier.com/courier-check', [
                    'phone' => $request->phone,
                ]);

                if ($response->successful()) {
                    $courierHistory = $response->body();
                }
            } catch (\Exception $e) {
                // Keep history empty if request fails
            }
        }

        $orderId = 'MBD-'.rand(100000, 999999);
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
            'ip_address' => $request->ip(),
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
            'courier_history' => $courierHistory,
        ]);

        session()->put('last_order', $order->id);

        return redirect()->route('order.success')->with('success', 'Your order has been placed successfully!');
    }

    /**
     * Order Confirmation Receipt Screen
     */
    public function orderSuccess()
    {
        $sessionData = session('last_order');
        $order = null;

        if ($sessionData) {
            if (is_numeric($sessionData)) {
                $order = Orders::find($sessionData);
            } elseif (is_array($sessionData) && isset($sessionData['id'])) {
                $order = Orders::find($sessionData['id']);
            } elseif (is_object($sessionData) && isset($sessionData->id)) {
                $order = Orders::find($sessionData->id);
            }
        }

        if (! $order) {
            $order = Orders::latest()->first();
        }

        if (! $order) {
            return redirect('/');
        }

        return view('success', compact('order'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
        ]);

        $orderId = 'MBD-'.rand(100000, 999999);
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
            'payment_method' => $request->payment_method ?? ' COD',
            'transaction_id' => $request->transaction_id ?? null,
            'order_date' => now()->format('Y-m-d H:i:s'),
            'product_id' => $request->product_items ?? ($request->product_name ?? 'Custom Item'),
            'product_color' => $request->product_color ?? 'N/A',
            'product_quantity' => strval($request->product_quantity ?? 1),
            'order_sub_total' => strval($subTotal),
            'delivery_cost' => strval($deliveryCost),
            'coupon_code' => $request->coupon_code ?? null,
            'coupon_discount' => strval($discount),
            'admin_discount' => '0',
            'grand_total' => strval($grandTotal),
            'order_status' => $request->order_status ?? 'Approved',
            'courier_history' => 'Processed via Admin interface.',
        ]);

        return redirect()->route('admin.orders.index')->with('success', "Order #{$orderId} created successfully!");
    }

    public function index(Request $request)
    {
        $query = Orders::latest();

        if ($request->has('status') && $request->status !== '' && $request->status !== 'All') {
            $query->where('order_status', $request->status);
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        if ($request->has('from_date') && $request->from_date !== '') {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date !== '') {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $orders = $query->get();
        $orderStatuses = OrderStatus::all();

        if ($request->ajax()) {
            $html = view('backend.orders.partials.order_rows', compact('orders', 'orderStatuses'))->render();

            return response()->json(['html' => $html]);
        }

        $dbStatusCounts = Orders::select('order_status', \DB::raw('count(*) as total'))
            ->groupBy('order_status')
            ->pluck('total', 'order_status')
            ->toArray();

        $statusCounts = [];
        foreach ($orderStatuses as $os) {
            $statusCounts[$os->name] = $dbStatusCounts[$os->name] ?? 0;
        }

        return view('backend.orders.index', compact('orders', 'statusCounts', 'orderStatuses'));
    }

    /**
     * Admin Order Lists by Status
     */
    public function statusIndex($id)
    {
        $status = OrderStatus::findOrFail($id);
        $orders = Orders::where('order_status', $status->name)->latest()->get();
        $orderStatuses = OrderStatus::all();

        $dbStatusCounts = Orders::select('order_status', \DB::raw('count(*) as total'))
            ->groupBy('order_status')
            ->pluck('total', 'order_status')
            ->toArray();

        $statusCounts = [];
        foreach ($orderStatuses as $os) {
            $statusCounts[$os->name] = $dbStatusCounts[$os->name] ?? 0;
        }

        return view('backend.orders.index', compact('orders', 'statusCounts', 'orderStatuses'));
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
        $oldStatus = $order->order_status;

        $order->update($request->except(['_token', '_method']));

        if ($request->has('order_status') && $oldStatus !== $request->order_status) {
            $order->orderLogs()->create([
                'order_status' => $request->order_status,
                'details' => "Status updated from {$oldStatus} to {$request->order_status}",
                'user_id' => auth()->id(),
            ]);
        }

        if ($request->ajax()) {
            $statusLower = strtolower($request->order_status);
            $badgeClass = 'badge-secondary';
            if (in_array($statusLower, ['pending', 'hold'])) {
                $badgeClass = 'badge-warning text-dark';
            }
            if (in_array($statusLower, ['processing', 'approved', 'shipped'])) {
                $badgeClass = 'badge-primary';
            }
            if ($statusLower == 'delivered') {
                $badgeClass = 'badge-success';
            }
            if (in_array($statusLower, ['cancelled', 'returned'])) {
                $badgeClass = 'badge-danger';
            }

            return response()->json([
                'success' => true,
                'status_text' => ucfirst($request->order_status),
                'badge_class' => $badgeClass,
            ]);
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Delete Order
     */
    public function destroy($id)
    {
        $order = Orders::findOrFail($id);
        $orderId = $order->order_id;
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', "Order #{$orderId} deleted successfully!");
    }

    /**
     * Send Orders to SteadFast Courier Bulk API
     */
    public function sendToSteadfastBulk(Request $request)
    {
        $orderIds = $request->order_ids;
        if (!$orderIds || empty($orderIds)) {
            return response()->json(['success' => false, 'message' => 'No orders selected.']);
        }

        $api = \App\Models\SystemAPI::where('api_name', 'SteadFast Courier')->first();
        if (!$api) {
            return response()->json(['success' => false, 'message' => 'SteadFast Courier API credentials not found in database.']);
        }

        $orders = Orders::whereIn('id', $orderIds)->get();
        $payloadData = [];
        $validOrderIds = [];

        foreach ($orders as $order) {
            // Prevent duplicate entries
            if (!empty($order->courier_history) && strpos($order->courier_history, 'consignment_id') !== false) {
                continue;
            }

            $payloadData[] = [
                'invoice' => $order->order_id,
                'recipient_name' => $order->customer_name,
                'recipient_phone' => $order->customer_phone,
                'recipient_address' => $order->customer_address . ', ' . $order->customer_district,
                'cod_amount' => (float) $order->grand_total,
                'note' => "Product: {$order->product_id}, Qty: {$order->product_quantity}"
            ];
            $validOrderIds[] = $order->id;
        }

        if (empty($payloadData)) {
            return response()->json(['success' => false, 'message' => 'All selected orders have already been sent to SteadFast.']);
        }

        $url = rtrim($api->api_url, '/') . '/create_order/bulk-order';
        
        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Api-Key' => $api->api_key,
                'Secret-Key' => $api->api_secret,
                'Content-Type' => 'application/json'
            ])->post($url, [
                'data' => $payloadData
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                $successCount = 0;
                
                // Steadfast returns array of data containing consignment_id
                if (isset($responseData['data']) && is_array($responseData['data'])) {
                    foreach ($responseData['data'] as $resData) {
                        if (isset($resData['consignment_id'])) {
                            Orders::where('order_id', $resData['invoice'])->update([
                                'order_status' => 'In-courier',
                                'courier_history' => json_encode([
                                    'consignment_id' => $resData['consignment_id'],
                                    'tracking_code' => $resData['tracking_code'] ?? '',
                                    'sent_at' => now()->toDateTimeString()
                                ])
                            ]);
                            $successCount++;
                        }
                    }
                } else {
                    Orders::whereIn('id', $validOrderIds)->update([
                        'order_status' => 'In-courier',
                        'courier_history' => json_encode([
                            'status' => 'Sent to Steadfast',
                            'response' => $responseData,
                            'sent_at' => now()->toDateTimeString()
                        ])
                    ]);
                    $successCount = count($validOrderIds);
                }

                return response()->json(['success' => true, 'message' => "$successCount orders successfully sent to SteadFast Courier."]);
            }

            return response()->json(['success' => false, 'message' => 'Failed to connect to SteadFast API. Status: ' . $response->status()]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'API Error: ' . $e->getMessage()]);
        }
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
        if (! $request->phone && ! $request->name) {
            return response()->json(['status' => 'error', 'message' => 'Insufficient data']);
        }

        $orderId = 'MBD-'.rand(100000, 999999);

        $order = Orders::create([
            'customer_name' => $request->name ?? 'Incomplete Lead',
            'customer_phone' => $request->phone ?? 'N/A',
            'customer_address' => $request->address ?? 'N/A',
            'customer_district' => $request->city ?? 'N/A',
            'order_id' => $orderId,
            'ip_address' => $request->ip(),
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
