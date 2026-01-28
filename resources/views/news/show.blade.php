<x-public-layout>
    <x-slot name="meta_title">{{ $post->meta_title ?? $post->title }}</x-slot>
    <x-slot name="meta_description">{{ $post->meta_description ?? $post->excerpt }}</x-slot>
    <x-slot name="meta_type">article</x-slot>
    @if($post->featured_image)
        <x-slot name="meta_image">{{ $post->featured_image }}</x-slot>
    @endif

    @push('head-scripts')
    @php
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "NewsArticle",
            "headline" => $post->meta_title ?? $post->title,
            "image" => [
                asset('storage/' . $post->featured_image)
            ],
            "datePublished" => $post->published_at ? $post->published_at->toIso8601String() : $post->created_at->toIso8601String(),
            "dateModified" => $post->updated_at->toIso8601String(),
            "author" => [
                [
                    "@type" => "Person",
                    "name" => $post->author->name,
                    "url" => route('news.author', $post->author)
                ]
            ],
            "publisher" => [
                "@type" => "Organization",
                "name" => config('app.name'),
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => asset('img/logo.png')
                ]
            ],
            "description" => $post->meta_description ?? $post->excerpt,
            "mainEntityOfPage" => [
                "@type" => "WebPage",
                "@id" => route('news.show', $post)
            ]
        ];
    @endphp
    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endpush

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content Column (Article + Comments) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Article -->
                <article class="bg-white dark:bg-gray-900/90 rounded-lg shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover">
                    @endif
                    
                    <div class="p-8">
                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <a href="{{ route('news.category', $post->category) }}" class="bg-blue-100 dark:bg-blue-900/60 text-blue-800 dark:text-blue-200 text-xs font-bold uppercase px-3 py-1 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                                {{ $post->category->name }}
                            </a>
                            <span>{{ $post->created_at->format('d M, Y') }}</span>
                            <span>Por <a href="{{ route('news.author', $post->author) }}" class="hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors">{{ $post->author->name }}</a></span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-50 mb-6 leading-tight">{{ $post->title }}</h1>

                        @if($post->iframe_embed)
                            <div class="my-6 aspect-w-16 aspect-h-9">
                                {!! $post->iframe_embed !!}
                            </div>
                        @endif

                        <div class="prose max-w-none text-gray-800 dark:text-gray-100 prose-headings:text-gray-900 prose-p:text-gray-800 dark:prose-headings:text-gray-50 dark:prose-p:text-gray-100 mb-8">
                            {!! $post->content_with_embeds !!}
                        </div>

                        <div class="border-t border-gray-100 dark:border-gray-700 pt-6 mt-6">
                            <!-- Share Buttons -->
                            <div class="mb-6">
                                <h3 class="text-sm font-bold text-gray-700 dark:text-gray-200 uppercase mb-3">Compartir:</h3>
                                <div class="flex flex-wrap gap-2">
                                    <!-- Facebook -->
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('news.show', $post)) }}" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 hover:bg-blue-700 text-white transition-colors" title="Compartir en Facebook">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </a>
                                    <!-- WhatsApp -->
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . route('news.show', $post)) }}" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-green-500 hover:bg-green-600 text-white transition-colors" title="Compartir en WhatsApp">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                    </a>
                                    <!-- X / Twitter -->
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('news.show', $post)) }}&text={{ urlencode($post->title) }}" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-black hover:bg-gray-800 text-white transition-colors" title="Compartir en X">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </a>
                                    <!-- LinkedIn -->
                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('news.show', $post)) }}&title={{ urlencode($post->title) }}" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-700 hover:bg-blue-800 text-white transition-colors" title="Compartir en LinkedIn">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                    </a>
                                </div>
                            </div>

                            <h3 class="text-sm font-bold text-gray-700 dark:text-gray-200 uppercase mb-3">Tags:</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($post->tags as $tag)
                                    <a href="{{ route('news.tag', $tag) }}" class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-gray-800 px-3 py-1 rounded text-sm transition">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar (Related Posts) -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Related Posts -->
                <div class="bg-white dark:bg-gray-900/90 rounded-lg shadow-md p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-50 mb-4 border-l-4 border-blue-500 pl-3">Relacionados</h3>
                    <div class="space-y-4">
                        @forelse($relatedPosts as $related)
                            <div class="flex gap-4 group">
                                @if($related->featured_image)
                                    <a href="{{ route('news.show', $related) }}" class="shrink-0 w-20 h-20 rounded-md overflow-hidden">
                                        <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    </a>
                                @endif
                                <div>
                                    <h4 class="text-sm font-bold leading-snug mb-1">
                                        <a href="{{ route('news.show', $related) }}" class="text-gray-900 dark:text-gray-100 hover:text-blue-600 dark:hover:text-blue-400 transition">{{ $related->title }}</a>
                                    </h4>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $related->created_at->format('d M, Y') }}</span>
                                </div>
                            </div>
                        @empty
                             <p class="text-gray-500 dark:text-gray-400 text-sm">No hay noticias relacionadas.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Comments Section (Moved here, below the main grid) -->
        <div class="mt-8 bg-white dark:bg-gray-900/90 rounded-lg shadow-md p-8 border border-gray-100 dark:border-gray-700">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-50 mb-6">Comentarios ({{ $comments->total() }})</h3>

            @if(session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @auth
                <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-8">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Comentario</label>
                        <textarea name="content" id="content" rows="4" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Escribe tu comentario aquí...">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition duration-150 ease-in-out">
                            Publicar Comentario
                        </button>
                    </div>
                </form>
            @else
                <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-lg text-center text-gray-500 dark:text-gray-300 mb-8">
                    <p class="mb-4">Debes iniciar sesión para publicar un comentario.</p>
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold">Registrarse</a>
                    </div>
                </div>
            @endauth

            <div class="space-y-6">
                @forelse($comments as $comment)
                    <div class="border-b border-gray-100 dark:border-gray-700 pb-6 last:border-0">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-900 dark:text-gray-100">{{ $comment->name }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">• {{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="text-gray-700 dark:text-gray-300 prose prose-sm dark:prose-invert max-w-none">
                            <p>{{ $comment->content }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                        No hay comentarios aún. ¡Sé el primero en comentar!
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-public-layout>