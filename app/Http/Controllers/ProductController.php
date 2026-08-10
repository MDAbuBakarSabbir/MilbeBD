<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('backend.product.index', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'regular_price' => 'required',
        ]);

        $product = new Product;
        $product->title = $request->title;
        $product->regular_price = $request->regular_price;
        $product->discounted_price = $request->discounted_price;
        $product->description = $request->description;
        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully');
    }
}
