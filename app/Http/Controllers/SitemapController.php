<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')
            ->latest('published_at')
            ->get();
            
        $pages = Page::where('is_active', true)
            ->get();
            
        $categories = Category::all();

        return response()->view('sitemap.index', [
            'posts' => $posts,
            'pages' => $pages,
            'categories' => $categories,
        ])->header('Content-Type', 'text/xml');
    }

    public function news()
    {
        // Google News Sitemap only needs posts from the last 48 hours
        $posts = Post::where('status', 'published')
            ->where('published_at', '>=', now()->subHours(48))
            ->latest('published_at')
            ->get();

        return response()->view('sitemap.news', [
            'posts' => $posts,
        ])->header('Content-Type', 'text/xml');
    }
}
