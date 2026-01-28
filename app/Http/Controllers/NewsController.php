<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category', 'author')
            ->where('status', 'published');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest('published_at')->paginate(9);
            
        return view('news.index', compact('posts'));
    }

    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }

        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();
        
        $comments = $post->comments()
            ->where('is_approved', true)
            ->latest()
            ->paginate(5);
        
        return view('news.show', compact('post', 'relatedPosts', 'comments'));
    }

    public function category(Category $category)
    {
        $posts = $category->posts()
            ->with('author')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);
            
        return view('news.category', compact('category', 'posts'));
    }

    public function tag(Tag $tag)
    {
        $posts = $tag->posts()
            ->with('author', 'category')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);
            
        return view('news.tag', compact('tag', 'posts'));
    }

    public function author(User $user)
    {
        $posts = $user->posts()
            ->with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);
            
        return view('news.author', compact('user', 'posts'));
    }
}
