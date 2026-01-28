<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'author')
            ->where('status', 'published')
            ->latest('id')
            ->take(11)
            ->get();
            
        $mainPost = $posts->first();
        $gridPosts = $posts->slice(1, 6); // 6 posts for grid
        $popularPosts = $posts->slice(7, 4); // 4 posts for sidebar
        
        $categories = Category::whereHas('posts', function($query) {
                $query->where('status', 'published');
            })
            ->with(['posts' => function($query) {
                $query->where('status', 'published')
                      ->latest('published_at')
                      ->take(5);
            }])
            ->get();

        $banners = Banner::where('active', true)
            ->orderBy('position')
            ->get();

        return view('welcome', compact('mainPost', 'gridPosts', 'popularPosts', 'categories', 'banners'));
    }
}
