<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($meta_title) ? $meta_title . ' - ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}</title>
        <meta name="description" content="{{ $meta_description ?? 'CMS de Noticias' }}">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="{{ $meta_type ?? 'website' }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ isset($meta_title) ? $meta_title : config('app.name', 'Laravel') }}">
        <meta property="og:description" content="{{ $meta_description ?? 'CMS de Noticias' }}">
        <meta property="og:image" content="{{ isset($meta_image) ? asset('storage/' . $meta_image) : asset('img/default-og.png') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ isset($meta_title) ? $meta_title : config('app.name', 'Laravel') }}">
        <meta property="twitter:description" content="{{ $meta_description ?? 'CMS de Noticias' }}">
        <meta property="twitter:image" content="{{ isset($meta_image) ? asset('storage/' . $meta_image) : asset('img/default-og.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @if(isset($site_settings) && $site_settings->favicon_path)
            <link rel="icon" href="{{ asset('storage/' . $site_settings->favicon_path) }}">
        @endif
        
        @stack('head-scripts')
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
        <div class="min-h-screen flex flex-col">
            <!-- Top Bar / Submenu -->
            <div class="bg-slate-900 text-white text-xs py-2">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <div class="hidden sm:flex space-x-4">
                        <span id="current-date-time">{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY, HH:mm:ss') }}</span>
                    </div>
                    
                    <div class="flex items-center space-x-6">
                        @if(isset($social_links) && $social_links->count() > 0)
                            <div class="flex items-center space-x-3 border-r border-slate-700 pr-4 mr-2">
                                @foreach($social_links as $link)
                                    <a href="{{ $link->url }}" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-200" title="{{ $link->name }}">
                                        @if($link->platform == 'facebook')
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        @elseif($link->platform == 'twitter')
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        @elseif($link->platform == 'instagram')
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                        @elseif($link->platform == 'linkedin')
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                        @elseif($link->platform == 'youtube')
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                        @elseif($link->platform == 'tiktok')
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                        @elseif($link->platform == 'github')
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        @if(isset($topBarLinks) && count($topBarLinks) > 0)
                            @foreach($topBarLinks as $link)
                                <a href="{{ $link->url }}" class="hover:text-blue-400 transition-colors">{{ $link->label }}</a>
                            @endforeach
                        @else
                            <a href="#" class="hover:text-blue-400 transition-colors">Nosotros</a>
                            <a href="#" class="hover:text-blue-400 transition-colors">Publicidad</a>
                            <a href="#" class="hover:text-blue-400 transition-colors">Suscríbete</a>
                        @endif
                        
                        @auth
                             <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-400 transition-colors font-bold text-blue-300">Panel Admin</a>
                        @else
                             <a href="{{ route('login') }}" class="hover:text-blue-400 transition-colors">Acceso Admin</a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="bg-white/80 dark:bg-gray-900/80 border-b border-gray-100/80 dark:border-gray-800 backdrop-blur-xl shadow-sm sticky top-0 z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 via-sky-500 to-indigo-500 text-white font-bold text-lg shadow-md">
                                        {{ isset($site_settings) ? substr($site_settings->site_name, 0, 2) : 'CN' }}
                                    </span>

                                    <span class="flex flex-col">
                                        <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ isset($site_settings) ? $site_settings->site_name : 'CMS News' }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 hidden sm:block">{{ isset($site_settings) ? $site_settings->site_description : 'Noticias rápidas, claras y optimizadas para SEO' }}</span>
                                    </span>
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                                    Inicio
                                </a>
                                <a href="{{ route('news.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('news.index') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                                    Noticias
                                </a>
                                <a href="{{ route('contact.show') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('contact.show') ? 'border-blue-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                                    Contacto
                                </a>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                            <!-- Search Form -->
                            <form action="{{ route('news.index') }}" method="GET" class="relative">
                                <input type="text" name="search" placeholder="Buscar..." value="{{ request('search') }}" class="w-40 lg:w-60 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border-none rounded-full py-1 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400 dark:placeholder-gray-500">
                                <button type="submit" class="absolute right-0 top-0 mt-1 mr-2 text-gray-400 hover:text-blue-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                            </form>

                            <!-- Dark Mode Toggle -->
                            <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                            </button>

                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-300 underline">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-300 underline">Log in</a>
                            @endauth
                        </div>
                        
                        <!-- Simple mobile brand (la navegación se muestra apilada por defecto) -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <a href="{{ route('contact.show') }}" class="mr-4 text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                                Contacto
                            </a>
                            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Inicio
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Categories Bar -->
            <div class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 relative z-40 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="py-5">
                        <div class="flex flex-wrap items-center justify-between w-full gap-y-4 text-base font-medium">
                            @if(isset($navbarCategories))
                                @foreach($navbarCategories->take(10) as $category)
                                    <a href="{{ route('news.category', $category) }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors whitespace-nowrap {{ request()->is('categoria/'.$category->slug) ? 'text-blue-600 dark:text-blue-400 font-bold' : '' }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach

                                @if($navbarCategories->count() > 10)
                                    <!-- Ver Más Dropdown -->
                                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                        <button class="flex items-center text-sm font-bold uppercase tracking-wide text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 focus:outline-none cursor-pointer">
                                            <span>Ver más</span>
                                            <svg x-bind:class="open ? 'rotate-180' : ''" class="w-5 h-5 ml-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div x-show="open" 
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 translate-y-1"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100 translate-y-0"
                                             x-transition:leave-end="opacity-0 translate-y-1"
                                             class="absolute right-0 top-full mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-xl rounded-lg z-50 overflow-hidden">
                                            <div class="py-1">
                                                @foreach($navbarCategories->skip(10) as $category)
                                                    <a href="{{ route('news.category', $category) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->is('categoria/'.$category->slug) ? 'bg-gray-50 dark:bg-gray-700/50 text-blue-600 dark:text-blue-400 font-bold' : '' }}">
                                                        {{ $category->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="flex-grow bg-gradient-to-b from-gray-50 via-gray-100 to-gray-50 dark:from-gray-950 dark:via-gray-900 dark:to-gray-950">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 mt-auto">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <!-- Site Info -->
                        <div>
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 via-sky-500 to-indigo-500 text-white font-bold text-sm shadow-md">
                                    {{ isset($site_settings) ? substr($site_settings->site_name, 0, 2) : 'CN' }}
                                </span>
                                <span class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{ isset($site_settings) ? $site_settings->site_name : 'CMS News' }}</span>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ isset($site_settings) ? $site_settings->site_description : 'Noticias rápidas, claras y optimizadas para SEO' }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('contact.show') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                                    Contáctanos
                                </a>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Enlaces Rápidos</h3>
                            <ul class="space-y-3">
                                @if(isset($footerCategories))
                                    @foreach($footerCategories as $category)
                                        <li>
                                            <a href="{{ route('news.category', $category) }}" class="text-base text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                                {{ $category->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <!-- Pages (Legal & Info) -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Información</h3>
                            <ul class="space-y-3">
                                @if(isset($footerPages) && $footerPages->count() > 0)
                                    @foreach($footerPages as $page)
                                        <li>
                                            <a href="{{ route('pages.show', $page->slug) }}" class="text-base text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                                {{ $page->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li><span class="text-sm text-gray-400 italic">No hay páginas disponibles</span></li>
                                @endif
                            </ul>
                        </div>

                        <!-- Newsletter / About -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Sobre Nosotros</h3>
                            <p class="text-base text-gray-500 dark:text-gray-400 mb-4">
                                {{ isset($site_settings) && $site_settings->footer_about_us ? $site_settings->footer_about_us : 'Somos tu fuente confiable de noticias actualizadas. Cubrimos los eventos más importantes con objetividad y rapidez.' }}
                            </p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mb-2">
                                &copy; {{ date('Y') }} {{ isset($site_settings) ? $site_settings->site_name : 'CMS News' }}. Todos los derechos reservados.
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        
        <script>
            // Live Clock Script
            function updateTime() {
                const now = new Date();
                const options = { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                };
                
                // Manually format if needed or use toLocaleString
                // To match PHP's "dddd, D [de] MMMM [de] YYYY, HH:mm:ss" approximately
                // "martes, 27 de enero de 2026, 23:15:00"
                
                // Using Intl.DateTimeFormat for Spanish
                const formatter = new Intl.DateTimeFormat('es-ES', options);
                const parts = formatter.formatToParts(now);
                
                // Constructing string to match PHP format closely if needed, 
                // but standard Spanish locale string is usually fine.
                // Let's use a custom construction to match "Tuesday, 27 de January de 2026, HH:mm:ss" style
                // but "de" is standard in Spanish dates.
                
                const dateStr = now.toLocaleDateString('es-ES', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                
                const timeStr = now.toLocaleTimeString('es-ES', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                });
                
                const element = document.getElementById('current-date-time');
                if (element) {
                    element.textContent = `${dateStr}, ${timeStr}`;
                }
            }
            
            // Update every second
            setInterval(updateTime, 1000);
            
            // Dark mode toggle logic
            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            // Change the icons inside the button based on previous settings
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
                document.documentElement.classList.add('dark');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
                document.documentElement.classList.remove('dark');
            }

            var themeToggleBtn = document.getElementById('theme-toggle');

            themeToggleBtn.addEventListener('click', function() {
                // toggle icons inside button
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // if set via local storage previously
                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }

                // if NOT set via local storage previously
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });
        </script>
    </body>
</html>
