<?php

namespace App\Http\Controllers;

use App\Models\Orders;
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
            'pending' => Orders::where('order_status', 'Pending')->count(),
            'today' => Orders::whereDate('created_at', today())->count(),
            'total' => Orders::count(),
            'total_sale' => Orders::sum('grand_total'),
            'delivered' => Orders::whereIn('order_status', ['Delivered', 'Completed'])->count(),
            'cancelled' => Orders::whereIn('order_status', ['Cancelled', 'Canceled'])->count(),
            'returned' => Orders::where('order_status', 'Returned')->count(),
            'incomplete' => Orders::where('order_status', 'Incomplete')->count(),
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

    public function siteSettings()
    {
        return view('backend.settings.generalSettings');
    }

    public function siteInfoUpdate(Request $request)
    {
        $settings = Settings::first();
        $settings->site_name = $request->site_name;
        $settings->site_description = $request->site_description;
        $settings->save();

        return redirect()->back()->with('success', 'Site information updated successfully!');
    }

    public function siteFaviconUpdate(Request $request)
    {
        $settings = Settings::first();
        $settings->site_favicon = $request->site_favicon;
        $settings->save();

        return redirect()->back()->with('success', 'Site favicon updated successfully!');
    }

    public function siteHeaderLogoUpdate(Request $request)
    {
        $settings = Settings::first();
        $settings->header_logo = $request->header_logo;
        $settings->save();

        return redirect()->back()->with('success', 'Site header logo updated successfully!');
    }

    public function siteFooterLogoUpdate(Request $request)
    {
        $settings = Settings::first();
        $settings->footer_logo = $request->footer_logo;
        $settings->save();

        return redirect()->back()->with('success', 'Site footer logo updated successfully!');
    }

    public function pixelGtagUpdate(Request $request)
    {
        $settings = Settings::first();
        $settings->pixel_gtag = $request->pixel_gtag;
        $settings->save();

        return redirect()->back()->with('success', 'Pixel and gtag updated successfully!');
    }
}
