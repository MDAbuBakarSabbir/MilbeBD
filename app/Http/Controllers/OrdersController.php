<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        return view('backend.orders.index');
    }

    public function create()
    {
        return view('backend.orders.create');
    }

    public function store(Request $request) {}

    public function adminStore(Request $request) {}

    public function show($id)
    {
        return view('backend.orders.show');
    }

    public function edit($id)
    {
        return view('backend.orders.edit');
    }

    public function update(Request $request, $id) {}

    public function destroy($id) {}

    public function incompleteView()
    {
        return view('backend.orders.incomplete');
    }

    public function incompleteStore(Request $request) {}
}
