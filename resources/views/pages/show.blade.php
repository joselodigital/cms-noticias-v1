<x-public-layout>
    <x-slot name="meta_title">{{ $page->meta_title ?? $page->title }}</x-slot>
    <x-slot name="meta_description">{{ $page->meta_description ?? Str::limit(strip_tags($page->content), 160) }}</x-slot>

    @push('head-scripts')
    @php
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => $page->meta_title ?? $page->title,
            "description" => $page->meta_description ?? Str::limit(strip_tags($page->content), 160),
            "url" => route('pages.show', $page->slug),
            "datePublished" => $page->created_at->toIso8601String(),
            "dateModified" => $page->updated_at->toIso8601String()
        ];
    @endphp
    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endpush

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-hidden">
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                    {{ $page->title }}
                </h1>
                
                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
