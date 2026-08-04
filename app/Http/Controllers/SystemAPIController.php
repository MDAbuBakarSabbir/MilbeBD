<?php

namespace App\Http\Controllers;

use App\Models\SystemAPI;
use Illuminate\Http\Request;

class SystemAPIController extends Controller
{
    public function courier_api()
    {
        $courierApis = SystemAPI::whereIn('api_name', ['SteadFast Courier', 'Pathao Courier'])->get()->keyBy('api_name');
        return view('backend.settings.courierApi', compact('courierApis'));
    }

    public function courier_api_create()
    {
        return view('backend.settings.courierApi');
    }

    public function courier_api_store(Request $request)
    {
        $request->validate([
            'api_name' => 'required|string',
        ]);

        SystemAPI::updateOrCreate(
            ['api_name' => $request->api_name],
            [
                'api_key' => $request->api_key,
                'api_secret' => $request->api_secret,
                'api_url' => $request->api_url,
                'api_status' => $request->has('status') ? 'Active' : 'Inactive',
            ]
        );

        return redirect()->back()->with('success', $request->api_name . ' configuration saved successfully.');
    }

    public function courier_api_update(Request $request, $id) {}

    public function courier_api_destroy($id) {}

    public function fraud_api()
    {
        $fraudApis = SystemAPI::whereIn('api_name', ['BD Courier API', 'Zachaikori API'])->get()->keyBy('api_name');
        return view('backend.settings.fraudCheck', compact('fraudApis'));
    }

    public function fraud_api_create()
    {
        return view('backend.settings.fraudCheck');
    }

    public function fraud_api_store(Request $request)
    {
        $request->validate([
            'api_name' => 'required|string',
        ]);

        SystemAPI::updateOrCreate(
            ['api_name' => $request->api_name],
            [
                'api_key' => $request->api_key,
                'api_url' => $request->api_url,
                'api_status' => $request->has('status') ? 'Active' : 'Inactive',
            ]
        );

        return redirect()->back()->with('success', $request->api_name . ' settings saved successfully.');
    }

    public function fraud_api_update(Request $request, $id) {}

    public function fraud_api_destroy($id) {}
}
