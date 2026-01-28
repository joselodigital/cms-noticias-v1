<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        View::composer('layouts.public', function ($view) {
            $view->with('navbarCategories', Category::orderBy('name')->get());
        });

        if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
            $settings = \App\Models\SiteSetting::first();
            
            if ($settings) {
                config(['app.name' => $settings->site_name]);
            }

            View::share('site_settings', $settings ?? new \App\Models\SiteSetting([
                'site_name' => 'CMS News',
                'site_description' => 'Noticias rápidas, claras y optimizadas para SEO',
            ]));
        }

        if (\Illuminate\Support\Facades\Schema::hasTable('social_links')) {
            View::share('social_links', \App\Models\SocialLink::all());
        }
    }
}
