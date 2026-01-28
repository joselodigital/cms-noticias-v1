<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', '¡Gracias por tu mensaje! Nos pondremos en contacto contigo pronto.');
    }
}
