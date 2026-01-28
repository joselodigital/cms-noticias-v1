<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para comentar.');
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = $user->id;
        $comment->name = $user->name;
        $comment->email = $user->email;
        $comment->content = $validated['content'];
        $comment->is_approved = true; // Aprobado por defecto para usuarios registrados
        $comment->save();

        return back()->with('success', 'Comentario publicado correctamente.');
    }
}
