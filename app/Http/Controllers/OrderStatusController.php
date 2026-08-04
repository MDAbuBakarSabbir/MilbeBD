<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderStatusController extends Controller
{
    public function index()
    {
        $orderStatuses = OrderStatus::all();

        return view('backend.settings.orderStatus', compact('orderStatuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status_name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        OrderStatus::create([
            'name' => $request->status_name,
            'status' => $request->status,
            'created_by' => Auth::id() ?? 1,
        ]);

        return redirect()->back()->with('success', 'Order status created successfully.');
    }

    public function status(Request $request) {}

    public function edit($id)
    {
        $orderStatus = OrderStatus::findOrFail($id);
        return response()->json($orderStatus);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status_name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $orderStatus = OrderStatus::findOrFail($id);
        $orderStatus->update([
            'name' => $request->status_name,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function destroy($id)
    {
        $orderStatus = OrderStatus::findOrFail($id);
        $orderStatus->delete();

        return redirect()->back()->with('success', 'Order status deleted successfully.');
    }
}
