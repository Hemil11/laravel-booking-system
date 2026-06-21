{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($staticUrls as $url => $priority)
        <url>
            <loc>{{ $url }}</loc>
            <lastmod>{{ now()->startOfDay()->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>{{ $priority }}</priority>
        </url>
    @endforeach
    @foreach($services as $service)
        <url>
            <loc>{{ route('frontend.services.show', ['id' => $service->id]) }}</loc>
            <lastmod>{{ $service->updated_at ? $service->updated_at->toAtomString() : now()->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
