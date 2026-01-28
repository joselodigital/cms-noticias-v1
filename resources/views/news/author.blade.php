<x-public-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Perfil del Autor -->
        <div class="mb-12 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="md:flex">
                <div class="md:flex-shrink-0 md:w-64 bg-gray-50 dark:bg-gray-900 flex flex-col items-center justify-center p-8 border-r border-gray-100 dark:border-gray-700">
                    @if($user->profile_photo_path)
                        <img class="h-32 w-32 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-md" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}">
                    @else
                        <div class="h-32 w-32 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 text-4xl font-bold border-4 border-white dark:border-gray-800 shadow-md">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif
                    <h1 class="mt-4 text-xl font-bold text-gray-900 dark:text-white text-center">{{ $user->name }}</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center">{{ $posts->total() }} Artículos</p>
                </div>
                
                <div class="p-8 md:flex-1 flex flex-col justify-center">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Sobre el Autor</h2>
                    @if($user->bio)
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">{{ $user->bio }}</p>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 italic mb-6">Este autor aún no ha añadido una biografía.</p>
                    @endif

                    @if($user->facebook || $user->twitter || $user->instagram || $user->linkedin)
                        <div class="flex items-center gap-4 mt-auto">
                            @if($user->facebook)
                                <a href="{{ $user->facebook }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-blue-600 transition-colors">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                                </a>
                            @endif
                            @if($user->twitter)
                                <a href="{{ $user->twitter }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-blue-400 transition-colors">
                                    <span class="sr-only">X (Twitter)</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                            @if($user->instagram)
                                <a href="{{ $user->instagram }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-pink-600 transition-colors">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.53c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                                </a>
                            @endif
                            @if($user->linkedin)
                                <a href="{{ $user->linkedin }}" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-blue-700 transition-colors">
                                    <span class="sr-only">LinkedIn</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" /></svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mb-8 border-b pb-4 border-gray-200/70 dark:border-gray-700/70">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-50 tracking-tight">
                Artículos publicados
            </h3>
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
                <h2 class="text-xl font-medium text-gray-600 dark:text-gray-200">Este autor aún no ha publicado noticias.</h2>
            </div>
        @endif
    </div>
</x-public-layout>
