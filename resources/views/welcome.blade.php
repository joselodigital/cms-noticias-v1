<x-public-layout>
    <x-slot name="meta_title">Inicio</x-slot>
    <x-slot name="meta_description">Bienvenido a {{ config('app.name') }} - Tu fuente confiable de noticias y novedades.</x-slot>

    @push('head-scripts')
    @php
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "WebSite",
            "url" => route('home'),
            "potentialAction" => [
                "@type" => "SearchAction",
                "target" => route('news.index') . "?search={search_term_string}",
                "query-input" => "required name=search_term_string"
            ]
        ];
    @endphp
    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endpush

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(isset($mainPost) && $mainPost)
            <div class="flex flex-col gap-12">
                
                <!-- SECCIÓN: NOTICIA PRINCIPAL (HERO) -->
                <!-- Diseño: Imagen de fondo + Texto superpuesto -->
                <article class="group relative w-full aspect-[16/9] lg:aspect-[21/9] min-h-[400px] rounded-xl overflow-hidden bg-gray-900 shadow-md">
                    <a href="{{ route('news.show', $mainPost) }}" class="block w-full h-full relative z-0">
                        @if($mainPost->featured_image)
                            <img src="{{ asset('storage/' . $mainPost->featured_image) }}?v={{ time() }}" alt="{{ $mainPost->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-90">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-600">
                                <svg class="w-20 h-20 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        
                        <!-- Overlay Gradiente -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/50 to-transparent"></div>
                        
                        @if($mainPost->hasVideo())
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="w-16 h-16 bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg backdrop-blur-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                        @endif
                    </a>
                    
                    <!-- Contenido Superpuesto -->
                    <div class="absolute bottom-0 left-0 w-full p-6 md:p-8 flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('news.category', $mainPost->category) }}" class="px-3 py-1 bg-blue-600 text-white text-xs font-bold uppercase tracking-wider rounded-sm hover:bg-blue-700 transition-colors z-10">
                                {{ $mainPost->category->name }}
                            </a>
                        </div>
                        
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-black text-white leading-tight drop-shadow-sm max-w-4xl z-10">
                            <a href="{{ route('news.show', $mainPost) }}" class="hover:text-blue-400 transition-colors">
                                {{ $mainPost->title }}
                            </a>
                        </h1>
                    </div>
                </article>

                <!-- SECCIÓN: CONTENIDO PRINCIPAL (GRIDS + SIDEBAR) -->
                @if((isset($gridPosts) && $gridPosts->count() > 0) || (isset($popularPosts) && $popularPosts->count() > 0))
                    <div class="border-t border-gray-100 dark:border-gray-800 pt-8">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                            
                            <!-- COLUMNA IZQUIERDA: ÚLTIMAS NOTICIAS (GRIDS) -->
                            <div class="lg:col-span-2">
                                <h3 class="text-lg font-black text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2 uppercase tracking-widest">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                                    Últimas Noticias
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-12">
                                    @foreach($gridPosts as $post)
                                        <article class="flex flex-col h-full group">
                                            <a href="{{ route('news.show', $post) }}" class="block aspect-[16/9] rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800 relative mb-4 shadow-sm group-hover:shadow-md transition-all duration-300">
                                                @if($post->featured_image)
                                                    <img src="{{ asset('storage/' . $post->featured_image) }}?v={{ time() }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-200 dark:bg-gray-700">
                                                        <svg class="w-10 h-10 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                                @if($post->hasVideo())
                                                    <div class="absolute top-2 right-2 bg-black/60 backdrop-blur-sm text-white p-1.5 rounded-full">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                                    </div>
                                                @endif
                                            </a>
                                            
                                            <div class="flex flex-col flex-grow">
                                                <div class="mb-2">
                                                    <a href="{{ route('news.category', $post->category) }}" class="inline-block text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest hover:underline">
                                                        {{ $post->category->name }}
                                                    </a>
                                                </div>
                                                
                                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 leading-snug mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-3">
                                                    <a href="{{ route('news.show', $post) }}">
                                                        {{ $post->title }}
                                                    </a>
                                                </h2>
                                                
                                                <div class="mt-auto pt-2 text-[11px] text-gray-400 dark:text-gray-500 font-medium uppercase tracking-wide flex items-center gap-2">
                                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>

                            <!-- COLUMNA DERECHA: LO MÁS LEÍDO (SIDEBAR) -->
                            <div class="lg:col-span-1">
                                <div class="sticky top-8">
                                    <h3 class="text-lg font-black text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2 uppercase tracking-widest">
                                        <span class="w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                                        Lo más leído
                                    </h3>

                                    <div class="flex flex-col gap-6">
                                        @foreach($popularPosts as $index => $post)
                                            <article class="group flex gap-4 items-start">
                                                <span class="text-3xl font-black text-gray-200 dark:text-gray-700 leading-none -mt-1 select-none">
                                                    {{ $index + 1 }}
                                                </span>
                                                <div class="flex flex-col">
                                                    <div class="mb-1">
                                                        <a href="{{ route('news.category', $post->category) }}" class="inline-block text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-widest hover:underline">
                                                            {{ $post->category->name }}
                                                        </a>
                                                    </div>
                                                    <h4 class="font-bold text-gray-900 dark:text-gray-100 leading-snug group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors line-clamp-3">
                                                        <a href="{{ route('news.show', $post) }}">
                                                            {{ $post->title }}
                                                        </a>
                                                    </h4>
                                                    <div class="mt-1 text-[11px] text-gray-400 dark:text-gray-500">
                                                        {{ $post->created_at->format('d M, Y') }}
                                                    </div>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                @endif

                <!-- SECCIÓN: CATEGORÍAS -->
                @if(isset($categories) && $categories->count() > 0)
                    <div class="flex flex-col gap-16 border-t border-gray-100 dark:border-gray-800 pt-12 mt-4">
                        @foreach($categories as $index => $category)
                            @if($category->posts->count() > 0)
                                <section>
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-2xl font-black text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                            <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                                            {{ $category->name }}
                                        </h3>
                                        <a href="{{ route('news.category', $category) }}" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline flex items-center gap-1">
                                            Ver más <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </div>

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                        <!-- IZQUIERDA: POST PRINCIPAL DE LA CATEGORÍA -->
                                        @php $catMainPost = $category->posts->first(); @endphp
                                        <article class="group relative aspect-[4/3] rounded-xl overflow-hidden bg-gray-900 shadow-md">
                                            <a href="{{ route('news.show', $catMainPost) }}" class="block w-full h-full relative z-0">
                                                @if($catMainPost->featured_image)
                                                    <img src="{{ asset('storage/' . $catMainPost->featured_image) }}?v={{ time() }}" alt="{{ $catMainPost->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-90">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-600">
                                                        <svg class="w-16 h-16 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                                            </a>
                                            
                                            <div class="absolute bottom-0 left-0 w-full p-6 flex flex-col gap-2">
                                                <h2 class="text-2xl font-bold text-white leading-tight drop-shadow-sm group-hover:text-blue-400 transition-colors">
                                                    <a href="{{ route('news.show', $catMainPost) }}">
                                                        {{ $catMainPost->title }}
                                                    </a>
                                                </h2>
                                                @if($catMainPost->excerpt)
                                                    <p class="text-gray-300 text-sm line-clamp-2 hidden sm:block">{{ $catMainPost->excerpt }}</p>
                                                @endif
                                                <span class="text-xs text-gray-400 mt-1">{{ $catMainPost->created_at->format('d F Y') }}</span>
                                            </div>
                                        </article>

                                        <!-- DERECHA: GRID 2x2 DE POSTS SECUNDARIOS -->
                                        @php $catGridPosts = $category->posts->skip(1)->take(4); @endphp
                                        @if($catGridPosts->count() > 0)
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                                @foreach($catGridPosts as $post)
                                                    <article class="flex flex-col group h-full">
                                                        <a href="{{ route('news.show', $post) }}" class="block aspect-[16/9] rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800 relative mb-3 shadow-sm group-hover:shadow-md transition-all duration-300">
                                                            @if($post->featured_image)
                                                                <img src="{{ asset('storage/' . $post->featured_image) }}?v={{ time() }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                                            @else
                                                                <div class="w-full h-full flex items-center justify-center text-gray-400 bg-gray-200 dark:bg-gray-700">
                                                                    <svg class="w-8 h-8 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                                </div>
                                                            @endif
                                                        </a>
                                                        <h4 class="font-bold text-gray-900 dark:text-gray-100 leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-3 mb-1">
                                                            <a href="{{ route('news.show', $post) }}">
                                                                {{ $post->title }}
                                                            </a>
                                                        </h4>
                                                        <span class="text-xs text-gray-500 mt-auto">{{ $post->created_at->format('d F Y') }}</span>
                                                    </article>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </section>
                                
                                <!-- BANNER PUBLICITARIO (CADA 2 CATEGORÍAS) -->
                                @if(($index + 1) % 2 == 0 && isset($banners))
                                    @php 
                                        // Calcular índice del banner basado en cuántos pares de categorías han pasado
                                        $bannerIndex = (($index + 1) / 2) - 1; 
                                        $banner = $banners->get($bannerIndex);
                                    @endphp
                                    
                                    @if($banner)
                                        <div class="w-full max-w-4xl mx-auto my-8 px-4">
                                            @if($banner->link)
                                                <a href="{{ $banner->link }}" target="_blank" rel="noopener noreferrer" class="block transition-transform hover:scale-[1.02] duration-300">
                                            @endif
                                            
                                            <img src="{{ asset('storage/' . $banner->image_path) }}" alt="{{ $banner->title ?? 'Publicidad' }}" class="w-full h-auto rounded-xl shadow-md object-cover">
                                            
                                            @if($banner->link)
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                @endif

                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="text-center py-20 bg-white dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                <h2 class="text-xl font-bold text-gray-700 dark:text-gray-200">No hay noticias destacadas aún.</h2>
                <p class="text-gray-500 mt-2">Vuelve más tarde para ver las últimas novedades.</p>
            </div>
        @endif
    </div>
</x-public-layout>