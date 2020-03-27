<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if ($post)
    <sitemap>
        <loc>{{ config('app.url', 'reallexi.com') }}/sitemap/posts</loc>
        <lastmod>{{ $post->created_at->tz('PST')->toAtomString() }}</lastmod>
    </sitemap>
    @endif
    @if ($feeds)
    <sitemap>
        <loc>{{ config('app.url', 'reallexi.com') }}/sitemap/feeds</loc>
        <lastmod>{{ $feeds->created_at->tz('PST')->toAtomString() }}</lastmod>
    </sitemap>
    @endif
</sitemapindex>
