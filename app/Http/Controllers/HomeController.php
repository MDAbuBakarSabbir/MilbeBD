<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $stats = [
            'pending'   => Orders::where('order_status', 'Pending')->count(),
            'today'     => Orders::whereDate('created_at', today())->count(),
            'total'     => Orders::count(),
            'total_sale'=> Orders::sum('grand_total'),
            'delivered' => Orders::whereIn('order_status', ['Delivered', 'Completed'])->count(),
            'cancelled' => Orders::whereIn('order_status', ['Cancelled', 'Canceled'])->count(),
            'returned'  => Orders::where('order_status', 'Returned')->count(),
            'incomplete'=> Orders::where('order_status', 'Incomplete')->count(),
        ];

        $recentOrders = Orders::latest()->take(10)->get();

        $topDistricts = Orders::select('customer_district', DB::raw('count(*) as order_count'))
            ->groupBy('customer_district')
            ->orderByDesc('order_count')
            ->take(5)
            ->get();

        $maxDistrictCount = $topDistricts->max('order_count') ?: 1;

        return view('backend.dashboard', compact('stats', 'recentOrders', 'topDistricts', 'maxDistrictCount'));
    }
}

