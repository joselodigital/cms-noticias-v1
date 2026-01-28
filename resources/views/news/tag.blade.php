<x-public-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8 border-b pb-4 border-gray-200/70 dark:border-gray-700/70">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-gray-50 tracking-tight">
                Tag: <span class="text-blue-600 dark:text-blue-400">#{{ $tag->name }}</span>
            </h1>
            <p class="text-gray-600 dark:text-gray-300 mt-3 text-sm md:text-base">Noticias etiquetadas con #{{ $tag->name }}.</p>
        </div>

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <div class="bg-white/95 dark:bg-gray-900/90 backdrop-blur rounded-2xl shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col h-full border border-gray-100 dark:border-gray-700">
                        <a href="{{ route('news.show', $post) }}" class="block h-48 overflow-hidden relative group">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">No Image</div>
                            @endif
                            <div class="absolute top-4 left-4 flex flex-col gap-1">
                                <span class="bg-blue-600/90 backdrop-blur text-white text-xs font-semibold uppercase px-3 py-1 rounded-full shadow">{{ $post->category->name }}</span>
                                @if($post->hasVideo())
                                    <span class="inline-flex items-center gap-1 bg-red-600/90 text-[11px] font-semibold uppercase px-2.5 py-1 rounded-full shadow">
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"></path></svg>
                                        Video
                                    </span>
                                @endif
                            </div>
                        </a>
                        <div class="p-6 flex-grow flex flex-col">
                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 flex justify-between">
                                <span class="inline-flex items-center gap-1">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    {{ $post->created_at->format('d M, Y') }}
                                </span>
                                <a href="{{ route('news.author', $post->author) }}" class="font-medium text-gray-700 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ $post->author->name }}</a>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-50 mb-3 leading-snug line-clamp-2">
                                <a href="{{ route('news.show', $post) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ $post->title }}</a>
                            </h2>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-3 flex-grow">{{ $post->excerpt }}</p>
                            <a href="{{ route('news.show', $post) }}" class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 font-semibold hover:underline mt-auto">
                                Leer más 
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-white dark:bg-gray-900/80 rounded-lg shadow border border-gray-100 dark:border-gray-700">
                <h2 class="text-xl font-medium text-gray-600 dark:text-gray-200">No hay noticias con este tag.</h2>
            </div>
        @endif
    </div>
</x-public-layout>
