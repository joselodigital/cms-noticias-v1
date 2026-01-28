<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        @if(isset($site_settings) && $site_settings->favicon_path)
            <link rel="icon" href="{{ asset('storage/' . $site_settings->favicon_path) }}">
        @endif
    </head>
    <body class="font-sans antialiased bg-slate-100 dark:bg-slate-950 transition-colors duration-300">
        <div class="min-h-screen flex bg-slate-100 dark:bg-slate-950">
            <!-- Mobile Overlay -->
            <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="toggleMobileMenu()"></div>

            <!-- Sidebar -->
            <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-slate-950/95 text-slate-800 dark:text-white min-h-screen transform -translate-x-full md:translate-x-0 md:static md:block border-r border-slate-200 dark:border-slate-800 transition-transform duration-300 ease-in-out shadow-lg md:shadow-none">
                <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 via-sky-500 to-indigo-500 text-white font-bold text-lg shadow-md">
                            {{ isset($site_settings) ? substr($site_settings->site_name, 0, 2) : 'CN' }}
                        </span>
                        <span class="flex flex-col">
                            <span class="text-lg font-semibold leading-tight text-slate-900 dark:text-slate-100">{{ isset($site_settings) ? $site_settings->site_name : 'CMS' }} Admin</span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-wide">Panel de noticias</span>
                        </span>
                    </a>
                    <!-- Close button for mobile -->
                    <button class="md:hidden text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-white focus:outline-none" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <nav class="mt-4 text-sm font-medium h-[calc(100vh-80px)] overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.dashboard') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.posts.*') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Noticias
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.categories.*') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Categorías
                    </a>
                    <a href="{{ route('admin.tags.index') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.tags.*') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Tags
                    </a>
                    <a href="{{ route('admin.banners.index') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.banners.*') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Banners
                    </a>
                    <a href="{{ route('admin.comments.index') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.comments.*') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Comentarios
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.users.*') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Usuarios
                    </a>
                    <a href="{{ route('admin.settings.edit') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.settings.*') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Configuración
                    </a>
                    <a href="{{ route('admin.social_links.index') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.social_links.*') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Redes Sociales
                    </a>
                    <a href="{{ route('admin.top_bar_links.index') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.top_bar_links.*') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Menú Superior
                    </a>
                    <a href="{{ route('admin.pages.index') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.pages.*') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Páginas Estáticas
                    </a>
                    <a href="{{ route('admin.messages.index') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 {{ request()->routeIs('admin.messages.*') ? 'bg-slate-100 dark:bg-slate-900 border-l-4 border-blue-500' : '' }}">
                        Mensajes
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 text-blue-600 dark:text-sky-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Ver Sitio Web
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80">
                        Perfil
                    </a>

                    <!-- Theme Toggle in Sidebar -->
                    <button onclick="toggleTheme()" class="w-full text-left flex items-center gap-2 px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 text-slate-600 dark:text-slate-300">
                        <svg id="theme-icon-moon" class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg id="theme-icon-sun" class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span id="theme-text">Cambiar Tema</span>
                    </button>

                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-6 py-3 hover:bg-slate-100 dark:hover:bg-slate-900/80 text-red-600 dark:text-red-400">
                            Cerrar Sesión
                        </button>
                    </form>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Mobile Header -->
                <header class="md:hidden bg-white dark:bg-slate-950/95 border-b border-slate-200 dark:border-slate-800 p-4 flex justify-between items-center sticky top-0 z-30 shadow-sm md:shadow-none">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-blue-500 via-sky-500 to-indigo-500 text-white font-semibold text-sm">
                            {{ isset($site_settings) ? substr($site_settings->site_name, 0, 2) : 'CN' }}
                        </span>
                        <span class="font-semibold text-sm text-slate-800 dark:text-slate-100">{{ isset($site_settings) ? $site_settings->site_name : 'CMS' }} Admin</span>
                    </div>
                    <button onclick="toggleMobileMenu()" class="text-slate-500 dark:text-gray-300 hover:text-slate-700 dark:hover:text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-4 md:p-6 overflow-y-auto w-full max-w-[100vw]">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
            function toggleMobileMenu() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('mobile-overlay');
                
                if (sidebar.classList.contains('-translate-x-full')) {
                    // Open menu
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Prevent scrolling
                } else {
                    // Close menu
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = ''; // Restore scrolling
                }
            }

            function toggleTheme() {
                const html = document.documentElement;
                const isDark = html.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                updateThemeUI(isDark);
            }

            function updateThemeUI(isDark) {
                const themeText = document.getElementById('theme-text');
                if(themeText) {
                    themeText.textContent = isDark ? 'Modo Oscuro' : 'Modo Claro';
                }
            }

            // Initialize UI text on load
            document.addEventListener('DOMContentLoaded', () => {
                const isDark = document.documentElement.classList.contains('dark');
                updateThemeUI(isDark);
            });
        </script>
    </body>
</html>
