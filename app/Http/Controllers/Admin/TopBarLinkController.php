<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopBarLink;
use Illuminate\Http\Request;

class TopBarLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = TopBarLink::orderBy('order')->get();
        return view('admin.top_bar_links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.top_bar_links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = $request->input('order', 0);

        TopBarLink::create($validated);

        return redirect()->route('admin.top_bar_links.index')->with('success', 'Enlace creado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TopBarLink $topBarLink)
    {
        return view('admin.top_bar_links.edit', compact('topBarLink'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TopBarLink $topBarLink)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $topBarLink->update($validated);

        return redirect()->route('admin.top_bar_links.index')->with('success', 'Enlace actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TopBarLink $topBarLink)
    {
        $topBarLink->delete();
        return back()->with('success', 'Enlace eliminado correctamente.');
    }
}
