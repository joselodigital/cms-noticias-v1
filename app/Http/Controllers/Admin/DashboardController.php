<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 'published')->count();
        $draftPosts = Post::where('status', 'draft')->count();
        $scheduledPosts = Post::where('status', 'scheduled')->count();
        $totalUsers = User::count();

        // Chart data: Posts per month for the last 6 months
        $postsPerMonth = Post::select(
            DB::raw('count(id) as count'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month_name")
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('month_name')
        ->orderBy('month_name')
        ->get();

        $labels = $postsPerMonth->pluck('month_name')->map(function($date) {
            return \Carbon\Carbon::parse($date)->translatedFormat('F Y');
        })->values();
        $data = $postsPerMonth->pluck('count')->values();

        return view('admin.dashboard', compact('totalPosts', 'publishedPosts', 'draftPosts', 'scheduledPosts', 'totalUsers', 'labels', 'data'));
    }
}
