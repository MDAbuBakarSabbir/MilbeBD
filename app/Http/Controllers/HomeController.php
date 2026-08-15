<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Settings;
use Illuminate\Http\Request;
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

        $recentOrders = Orders::latest()->take(4)->get();

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
        $settings = Settings::first() ?? new Settings;

        return view('backend.settings.generalSettings', compact('settings'));
    }

    public function siteInfoUpdate(Request $request)
    {
        $settings = Settings::first() ?? new Settings;
        $settings->site_name = $request->site_name;
        $settings->site_description = $request->site_description;
        $settings->sitetag = $request->sitetag;
        $settings->save();

        return redirect()->route('admin.siteSettings')->with('success', 'Site information updated successfully!');
    }

    public function siteContactUpdate(Request $request)
    {
        $settings = Settings::first() ?? new Settings;
        $settings->phone = $request->phone;
        $settings->email = $request->email;
        $settings->address = $request->address;
        $settings->save();

        return redirect()->route('admin.siteSettings')->with('success', 'Contact details updated successfully!');
    }

    public function siteFaviconUpdate(Request $request)
    {
        $settings = Settings::first() ?? new Settings;
        $settings->site_favicon = $request->site_favicon;
        $settings->save();

        return redirect()->route('admin.siteSettings')->with('success', 'Site favicon updated successfully!');
    }

    public function siteHeaderLogoUpdate(Request $request)
    {
        $settings = Settings::first() ?? new Settings;
        $settings->site_logo = $request->site_logo;
        $settings->save();

        return redirect()->route('admin.siteSettings')->with('success', 'Site header logo updated successfully!');
    }

    public function siteFooterLogoUpdate(Request $request)
    {
        $settings = Settings::first() ?? new Settings;
        $settings->site_logo_footer = $request->site_logo_footer;
        $settings->save();

        return redirect()->route('admin.siteSettings')->with('success', 'Site footer logo updated successfully!');
    }

    public function pixelGtagUpdate(Request $request)
    {
        $settings = Settings::first() ?? new Settings;
        $settings->meta_pixel = $request->meta_pixel;
        $settings->google_analytics = $request->google_analytics;
        $settings->save();

        return redirect()->route('admin.siteSettings')->with('success', 'Pixel and gtag updated successfully!');
    }
}
