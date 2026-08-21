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
        $product->color = $request->color ?? 'স্ট্যান্ডার্ড';
        $product->regular_price = $request->regular_price;
        $product->discounted_price = $request->discounted_price;
        $product->description = $request->description;
        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'regular_price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->title = $request->title;
        $product->color = $request->color ?? 'স্ট্যান্ডার্ড';
        $product->regular_price = $request->regular_price;
        $product->discounted_price = $request->discounted_price;
        
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('image/product'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
    }
}
