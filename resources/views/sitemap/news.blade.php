<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    @foreach($posts as $post)
    <url>
        <loc>{{ route('news.show', $post) }}</loc>
        <news:news>
            <news:publication>
                <news:name>{{ config('app.name') }}</news:name>
                <news:language>{{ str_replace('_', '-', app()->getLocale()) }}</news:language>
            </news:publication>
            <news:publication_date>{{ $post->published_at ? $post->published_at->toAtomString() : $post->created_at->toAtomString() }}</news:publication_date>
            <news:title>{{ $post->title }}</news:title>
        </news:news>
    </url>
    @endforeach
</urlset>