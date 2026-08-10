<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reviews;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index()
    {
        $reviews = Reviews::all();
        $products = Product::all();

        return view('backend.reviews', compact('reviews', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $review = new Reviews;
        // The column in migration is 'product' but stores the product ID
        $review->product = $request->product_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'reviews-'.rand(1, 1000).time().'.webp';
            $uploadPath = public_path('uploads');
            $destinationPath = $uploadPath.'/'.$imageName;

            if (! file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $sourcePath = $image->getRealPath();
            $mime = $image->getMimeType();
            $img = null;

            switch ($mime) {
                case 'image/jpeg':
                case 'image/jpg':
                    $img = @imagecreatefromjpeg($sourcePath);
                    break;
                case 'image/png':
                    $img = @imagecreatefrompng($sourcePath);
                    if ($img) {
                        imagepalettetotruecolor($img);
                        imagealphablending($img, true);
                        imagesavealpha($img, true);
                    }
                    break;
                case 'image/gif':
                    $img = @imagecreatefromgif($sourcePath);
                    break;
            }

            if ($img !== false && $img !== null) {
                imagewebp($img, $destinationPath, 80); // 80% quality for smaller size
                imagedestroy($img);
            } else {
                // Fallback (e.g. already webp or GD failed)
                $image->move(public_path('uploads'), $imageName);
            }

            $review->image = $imageName;
        }

        $review->save();

        if ($request->ajax()) {
            $productName = Product::find($review->product)?->name ?? 'N/A';

            return response()->json([
                'success' => true,
                'review' => $review,
                'image_url' => asset('uploads/'.$review->image),
                'product_name' => $productName,
                'message' => 'Review created successfully!',
            ]);
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Review created successfully!');
    }

    public function edit($id)
    {
        $review = Reviews::find($id);

        return view('backend.reviews', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = Reviews::find($id);
        $review->name = $request->name;
        $review->email = $request->email;
        $review->message = $request->message;
        $review->status = $request->status;
        $review->save();

        return redirect()->route('admin.reviews.index')->with('success', 'Review updated successfully!');
    }

    public function destroy($id)
    {
        $review = Reviews::find($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully!');
    }

    public function status(Request $request)
    {
        $review = Reviews::find($request->id);
        $review->status = $request->status;
        $review->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review status updated successfully!',
                'new_status' => $review->status
            ]);
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Review status updated successfully!');
    }
}
