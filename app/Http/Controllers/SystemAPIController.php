<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemAPIController extends Controller
{
    public function index()
    {
        return view('backend.settings.courierApi');
    }

    public function store(Request $request) {}

    public function update(Request $request, $id) {}

    public function destroy($id) {}
}
