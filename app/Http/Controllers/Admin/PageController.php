<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $slug = Str::slug($request->title);
        
        // Ensure unique slug
        if (Page::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . time();
        }

        Page::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Página creada exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Only update slug if title changes significantly or manually requested (here simplified to auto-update if different, but usually better to keep slug unless explicitly changed. For simplicity we keep slug unless collision logic needed, but let's just keep original slug or update it? Let's update it if title changes for now, or better: keep it stable.)
        // Actually, for SEO, better not to change slug automatically. Let's keep it unless we add a slug field.
        // Simplified: Keep slug as is.

        $page->update([
            'title' => $request->title,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Página actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')
            ->with('success', 'Página eliminada exitosamente.');
    }
}
