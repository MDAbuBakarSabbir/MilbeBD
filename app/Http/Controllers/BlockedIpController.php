<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlockedIp;

class BlockedIpController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['ip_address' => 'required|ip']);
        BlockedIp::firstOrCreate(['ip_address' => $request->ip_address], ['reason' => $request->reason]);
        return back()->with('success', 'IP Blocked successfully.');
    }

    public function destroy($id)
    {
        BlockedIp::findOrFail($id)->delete();
        return back()->with('success', 'IP Unblocked successfully.');
    }
}
