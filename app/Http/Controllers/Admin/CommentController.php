<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['post', 'user'])->latest()->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    public function toggleApproval(Comment $comment)
    {
        $comment->is_approved = !$comment->is_approved;
        $comment->save();

        $status = $comment->is_approved ? 'aprobado' : 'rechazado';
        return back()->with('success', "Comentario {$status} correctamente.");
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comentario eliminado correctamente.');
    }
}
