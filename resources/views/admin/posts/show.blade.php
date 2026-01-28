<x-admin-layout>
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">Detalles de la Noticia</h1>
        <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 disabled:opacity-25 transition ease-in-out duration-150">
            Volver
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-lg shadow overflow-hidden p-6 transition-colors">
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $post->title }}</h2>
            <div class="text-sm text-gray-600 dark:text-slate-300 mt-1">
                Por {{ $post->author->name }} | {{ $post->created_at->format('d/m/Y H:i') }} | 
                <span class="font-semibold">{{ $post->category->name }}</span>
                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $post->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100' }}">
                    {{ ucfirst($post->status) }}
                </span>
            </div>
        </div>

        @if($post->featured_image)
            <div class="mb-6">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-lg">
            </div>
        @endif

        <div class="prose dark:prose-invert max-w-none mb-6">
            {!! $post->content !!}
        </div>

        <div class="border-t border-gray-200 dark:border-slate-700 pt-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">SEO Metadata</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <span class="block text-sm font-medium text-gray-700 dark:text-slate-300">Meta Title</span>
                    <p class="text-gray-600 dark:text-slate-400">{{ $post->meta_title }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-700 dark:text-slate-300">Meta Description</span>
                    <p class="text-gray-600 dark:text-slate-400">{{ $post->meta_description }}</p>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tags</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($post->tags as $tag)
                    <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
</x-admin-layout>