<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'iframe_embed',
        'featured_image',
        'category_id',
        'author_id',
        'status',
        'published_at',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function hasVideo(): bool
    {
        if (! $this->content) {
            return false;
        }

        $content = $this->content;

        return str_contains($content, 'youtube.com') ||
            str_contains($content, 'youtu.be') ||
            str_contains($content, 'vimeo.com') ||
            str_contains($content, 'facebook.com') ||
            str_contains($content, 'fb.watch') ||
            str_contains($content, 'instagram.com') ||
            str_contains($content, 'tiktok.com') ||
            str_contains($content, 'spotify.com') ||
            str_contains($content, 'music.apple.com') ||
            str_contains($content, '<iframe');
    }

    public function getContentWithEmbedsAttribute(): string
    {
        if (! $this->content) {
            return '';
        }

        $content = $this->content;

        $content = $this->processYoutubeEmbeds($content);
        $content = $this->processVimeoEmbeds($content);
        $content = $this->processScribdEmbeds($content);
        $content = $this->processFacebookEmbeds($content);
        $content = $this->processInstagramEmbeds($content);
        $content = $this->processTikTokEmbeds($content);
        $content = $this->processSpotifyEmbeds($content);
        $content = $this->processAppleMusicEmbeds($content);

        return $content;
    }

    protected function processYoutubeEmbeds(string $content): string
    {
        // Link wrapper
        $content = preg_replace_callback(
            '/<a[^>]+href=\"(https?:\/\/(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)[^\"\'\s]+)\"[^>]*>.*?<\/a>/i',
            fn ($matches) => $this->convertYoutubeMatch($matches[1], $matches[0]),
            $content
        );

        // Oembed wrapper
        $content = preg_replace_callback(
            '/<oembed[^>]+url=\"(https?:\/\/(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)[^\"\'\s]+)\"[^>]*>(.*?)<\/oembed>/i',
            fn ($matches) => $this->convertYoutubeMatch($matches[1], $matches[0]),
            $content
        );

        // Plain text URL
        $content = preg_replace_callback(
            '/(?<![\"\'=])(https?:\/\/(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)[^\s<]+)/i',
            fn ($matches) => $this->convertYoutubeMatch($matches[1], $matches[1]),
            $content
        );

        return $content;
    }

    protected function convertYoutubeMatch($url, $original)
    {
        $videoId = $this->extractYoutubeId($url);
        return $videoId ? $this->youtubeIframe($videoId) : $original;
    }

    protected function processScribdEmbeds(string $content): string
    {
        return preg_replace_callback(
            '/https?:\/\/(?:www\.|es\.)?scribd\.com\/document\/(\d+)(?:\/[^\s<]*)?/i',
            fn ($matches) => $this->scribdIframe($matches[1]),
            $content
        );
    }

    protected function scribdIframe($id)
    {
        return '<div class="aspect-w-16 aspect-h-9 my-4"><iframe class="scribd_iframe_embed" src="https://www.scribd.com/embeds/'.$id.'/content?start_page=1&view_mode=scroll" frameborder="0" scrolling="no" width="100%" height="600px"></iframe></div>';
    }

    protected function processVimeoEmbeds(string $content): string
    {
        // Vimeo URLs
        // https://vimeo.com/123456789
        // https://vimeo.com/channels/staffpicks/123456789
        
        // Handle <a> tags wrapper first
        $content = preg_replace_callback(
            '/<a[^>]+href=\"(https?:\/\/(?:www\.)?vimeo\.com\/(?:channels\/[a-zA-Z0-9]+\/)?[0-9]+(?:[^\"]*))\"[^>]*>.*?<\/a>/i',
            fn ($matches) => $this->vimeoEmbed($matches[1]),
            $content
        );

        $content = preg_replace_callback(
            '/<oembed[^>]+url=\"(https?:\/\/(?:www\.)?vimeo\.com\/(?:channels\/[a-zA-Z0-9]+\/)?[0-9]+(?:[^\"]*))\"[^>]*>(.*?)<\/oembed>/i',
            fn ($matches) => $this->vimeoEmbed($matches[1]),
            $content
        );

        // Plain text URL (handle query params)
        $pattern = '/(?<![\"\'=])(https?:\/\/(?:www\.)?vimeo\.com\/(?:channels\/[a-zA-Z0-9]+\/)?([0-9]+)(?:\?[^\s<]*)?)/i';

        return preg_replace_callback(
            $pattern,
            fn ($matches) => $this->vimeoEmbed($matches[1]),
            $content
        );
    }

    protected function processFacebookEmbeds(string $content): string
    {
        // Facebook URLs (Post, Video, Watch)
        $pattern = '/(?<![\"\'=])(https?:\/\/(?:www\.|web\.|m\.)?(?:facebook\.com|fb\.watch)\/(?:[^\s<]+\/)?(?:videos\/|posts\/|watch\/\?v=|reel\/)[^\s<]+)/i';
        
        // Also handle oembed tags from CKEditor/similar editors
        $content = preg_replace_callback(
            '/<oembed[^>]+url=\"(https?:\/\/(?:www\.|web\.|m\.)?(?:facebook\.com|fb\.watch)\/[^\"\'\s]+)\"[^>]*>(.*?)<\/oembed>/i',
            fn ($matches) => $this->facebookEmbed($matches[1]),
            $content
        );

        return preg_replace_callback(
            $pattern,
            fn ($matches) => $this->facebookEmbed($matches[1]),
            $content
        );
    }

    protected function processInstagramEmbeds(string $content): string
    {
        // Instagram URLs (Post, Reel)
        $pattern = '/(?<![\"\'=])(https?:\/\/(?:www\.)?instagram\.com\/(?:p|reel)\/([a-zA-Z0-9_-]+)\/?)/i';

        $content = preg_replace_callback(
            '/<oembed[^>]+url=\"(https?:\/\/(?:www\.)?instagram\.com\/(?:p|reel)\/[^\"\'\s]+)\"[^>]*>(.*?)<\/oembed>/i',
            fn ($matches) => $this->instagramEmbed($matches[1]),
            $content
        );

        return preg_replace_callback(
            $pattern,
            fn ($matches) => $this->instagramEmbed($matches[1]),
            $content
        );
    }

    protected function processTikTokEmbeds(string $content): string
    {
        // TikTok URLs
        $pattern = '/(?<![\"\'=])(https?:\/\/(?:www\.)?tiktok\.com\/@[^\/]+\/video\/(\d+))/i';

        $content = preg_replace_callback(
            '/<oembed[^>]+url=\"(https?:\/\/(?:www\.)?tiktok\.com\/@[^\/]+\/video\/\d+)\"[^>]*>(.*?)<\/oembed>/i',
            fn ($matches) => $this->tikTokEmbed($matches[1]),
            $content
        );

        return preg_replace_callback(
            $pattern,
            fn ($matches) => $this->tikTokEmbed($matches[1]),
            $content
        );
    }

    protected function processSpotifyEmbeds(string $content): string
    {
        // Spotify URLs (Track, Album, Playlist, Artist, Episode)
        // https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT
        // https://open.spotify.com/intl-es/track/2yOccEzvCS2Zwyax7Fgju4
        // https://open.spotify.com/embed/artist/2DgKzo1ATaxzTS2lHxdQWg?utm_source=generator
        $pattern = '/(?<![\"\'=])(https?:\/\/open\.spotify\.com\/(?:intl-[a-z]+\/)?(?:embed\/)?(?:track|album|playlist|artist|episode)\/[a-zA-Z0-9]+(?:\?[a-zA-Z0-9_=&-]+)?)/i';

        $content = preg_replace_callback(
            '/<oembed[^>]+url=\"(https?:\/\/open\.spotify\.com\/(?:intl-[a-z]+\/)?(?:embed\/)?(?:track|album|playlist|artist|episode)\/[^\"\'\s]+)\"[^>]*>(.*?)<\/oembed>/i',
            fn ($matches) => $this->spotifyEmbed($matches[1]),
            $content
        );

        return preg_replace_callback(
            $pattern,
            fn ($matches) => $this->spotifyEmbed($matches[1]),
            $content
        );
    }

    protected function processAppleMusicEmbeds(string $content): string
    {
        // Apple Music URLs
        // https://music.apple.com/us/album/song-name/123456789
        // https://embed.music.apple.com/...
        $pattern = '/(?<![\"\'=])(https?:\/\/(?:embed\.)?music\.apple\.com\/[a-z]{2}\/(?:album|playlist|station)\/[^\s<]+)/i';

        $content = preg_replace_callback(
            '/<oembed[^>]+url=\"(https?:\/\/(?:embed\.)?music\.apple\.com\/[a-z]{2}\/(?:album|playlist|station)\/[^\"\'\s]+)\"[^>]*>(.*?)<\/oembed>/i',
            fn ($matches) => $this->appleMusicEmbed($matches[1]),
            $content
        );

        return preg_replace_callback(
            $pattern,
            fn ($matches) => $this->appleMusicEmbed($matches[1]),
            $content
        );
    }

    protected function extractYoutubeId(string $url): ?string
    {
        if (str_contains($url, 'youtu.be/')) {
            $parts = explode('/', parse_url($url, PHP_URL_PATH));
            $id = end($parts);
            return $id ?: null;
        }

        $query = parse_url($url, PHP_URL_QUERY);

        if (! $query) {
            return null;
        }

        parse_str($query, $params);

        return $params['v'] ?? null;
    }

    protected function youtubeIframe(string $videoId): string
    {
        $src = 'https://www.youtube.com/embed/' . htmlspecialchars($videoId, ENT_QUOTES, 'UTF-8');

        return '<div class="aspect-video w-full my-6 rounded-xl overflow-hidden shadow-lg">'
            . '<iframe width="560" height="315" src="' . $src . '" '
            . 'title="YouTube video player" frameborder="0" '
            . 'allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" '
            . 'referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>'
            . '</div>';
    }

    protected function vimeoEmbed(string $url): string
    {
        // Extract video ID
        preg_match('/(?:vimeo\.com\/)(?:channels\/[a-zA-Z0-9]+\/)?([0-9]+)/', $url, $matches);
        $videoId = $matches[1] ?? '';

        if (!$videoId) {
            return $url;
        }

        $src = 'https://player.vimeo.com/video/' . $videoId;

        return '<div class="aspect-video w-full my-6 rounded-xl overflow-hidden shadow-lg">'
            . '<iframe src="' . $src . '" width="640" height="360" frameborder="0" '
            . 'allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>'
            . '</div>';
    }

    protected function facebookEmbed(string $url): string
    {
        $encodedUrl = urlencode($url);
        $type = (str_contains($url, '/videos/') || str_contains($url, 'watch') || str_contains($url, 'reel')) ? 'video' : 'post';
        
        $src = "https://www.facebook.com/plugins/{$type}.php?href={$encodedUrl}&width=500&show_text=true&height=null&appId";

        return '<div class="flex justify-center my-6 rounded-xl overflow-hidden shadow-sm bg-white dark:bg-gray-800 p-2">'
            . '<iframe src="' . $src . '" width="500" height="' . ($type === 'video' ? '300' : '500') . '" '
            . 'style="border:none;overflow:hidden" scrolling="no" frameborder="0" '
            . 'allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>'
            . '</div>';
    }

    protected function instagramEmbed(string $url): string
    {
        // Extract ID to ensure clean URL construction if needed, but embed works with full URL usually.
        // Or simpler: clean URL to remove query params
        $urlPath = parse_url($url, PHP_URL_PATH);
        $cleanUrl = 'https://www.instagram.com' . $urlPath;
        if (!str_ends_with($cleanUrl, '/')) {
            $cleanUrl .= '/';
        }
        $src = $cleanUrl . 'embed';

        return '<div class="flex justify-center my-6">'
            . '<iframe class="instagram-media instagram-media-rendered" src="' . $src . '" '
            . 'allowtransparency="true" allowfullscreen="true" frameborder="0" height="600" '
            . 'data-instgrm-payload-id="instagram-media-payload-0" scrolling="no" '
            . 'style="background: white; max-width: 540px; width: calc(100% - 2px); border-radius: 3px; border: 1px solid rgb(219, 219, 219); box-shadow: none; display: block; margin: 0px 0px 12px; min-width: 326px; padding: 0px;"></iframe>'
            . '</div>';
    }

    protected function tikTokEmbed(string $url): string
    {
        // Extract video ID for data attribute
        preg_match('/video\/(\d+)/', $url, $matches);
        $videoId = $matches[1] ?? '';

        return '<div class="flex justify-center my-6">'
            . '<blockquote class="tiktok-embed" cite="' . $url . '" data-video-id="' . $videoId . '" style="max-width: 605px;min-width: 325px;">'
            . '<section> <a target="_blank" href="' . $url . '">' . $url . '</a> </section>'
            . '</blockquote>'
            . '<script async src="https://www.tiktok.com/embed.js"></script>'
            . '</div>';
    }

    protected function spotifyEmbed(string $url): string
    {
        // Parse URL to reconstruct a clean embed URL
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? '';
        
        // Remove intl-xx prefix if present (e.g. /intl-es/track/...)
        $path = preg_replace('/^\/intl-[a-z]+\//', '/', $path);
        
        // Ensure /embed prefix
        if (!str_starts_with($path, '/embed/')) {
            // Ensure we don't double slash if path starts with /
            $path = '/embed' . (str_starts_with($path, '/') ? $path : '/' . $path);
        }

        $src = 'https://open.spotify.com' . $path;

        return '<div class="my-6">'
            . '<iframe style="border-radius:12px" src="' . $src . '" width="100%" height="352" frameBorder="0" '
            . 'allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>'
            . '</div>';
    }

    protected function appleMusicEmbed(string $url): string
    {
        // Handle URLs that might already be embed URLs
        $src = $url;
        if (!str_contains($url, 'embed.music.apple.com')) {
            $src = str_replace('music.apple.com', 'embed.music.apple.com', $url);
        }

        return '<div class="my-6">'
            . '<iframe allow="autoplay *; encrypted-media *; fullscreen *; clipboard-write" frameborder="0" height="450" '
            . 'style="width:100%;max-width:660px;overflow:hidden;background:transparent;" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" '
            . 'src="' . $src . '"></iframe>'
            . '</div>';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->where('is_approved', true)->latest();
    }
}
