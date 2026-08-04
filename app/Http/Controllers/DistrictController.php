<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::latest()->get();
        return view('backend.settings.district', compact('districts'));
    }

    public function create()
    {
        return view('backend.settings.district');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'delivery_charge' => 'required|numeric|min:0',
        ]);

        District::create([
            'name' => $request->name,
            'delivery_charge' => $request->delivery_charge,
            'status' => $request->has('status') ? '1' : '0',
        ]);

        return redirect()->route('admin.districts.index')->with('success', 'District added successfully.');
    }

    public function edit($id)
    {
        $districts = District::latest()->get();
        $editDistrict = District::findOrFail($id);
        return view('backend.settings.district', compact('districts', 'editDistrict'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'delivery_charge' => 'required|numeric|min:0',
        ]);

        $district = District::findOrFail($id);
        $district->update([
            'name' => $request->name,
            'delivery_charge' => $request->delivery_charge,
            'status' => $request->has('status') ? '1' : '0',
        ]);

        return redirect()->route('admin.districts.index')->with('success', 'District updated successfully.');
    }

    public function destroy($id)
    {
        District::findOrFail($id)->delete();
        return redirect()->route('admin.districts.index')->with('success', 'District deleted successfully.');
    }
}
