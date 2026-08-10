<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Pages::latest()->get();

        return view('backend.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('backend.pages.create');
    }

    public function store(Request $request)
    {
        // validate request
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        // Create page
        $page = new Pages;
        $page->title = $validatedData['title'];
        $page->content = $validatedData['content'];
        $page->slug = Str::slug($validatedData['title']);
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully');
    }

    public function edit($id)
    {
        $page = Pages::find($id);

        return view('backend.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        // validate request
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        // Update page
        $page = Pages::find($id);
        $page->title = $validatedData['title'];
        $page->content = $validatedData['content'];
        $page->save();

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully');
    }

    public function destroy($id)
    {
        $page = Pages::find($id);
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully');
    }

    public function status(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:pages,id',
            'status' => 'required|boolean',
        ]);

        $page = Pages::find($request->id);
        $page->status = $request->status;
        $page->save();

        return response()->json([
            'success' => true,
            'message' => 'Page status updated successfully',
        ]);
    }

    public function showPage($slug)
    {
        $page = Pages::where('slug', $slug)->where('status', 1)->firstOrFail();
        
        // Also fetch all active pages for the footer links
        $pages = Pages::where('status', 1)->get();
        
        return view('page', compact('page', 'pages'));
    }
}
