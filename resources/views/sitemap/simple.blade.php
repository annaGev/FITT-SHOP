<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Статические страницы -->
    @foreach($pages as $page)
    <url>
        <loc>{{ $page['url'] }}</loc>
        <lastmod>{{ now()->toDateString() }}</lastmod>
        <changefreq>{{ $page['changefreq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach
    
    <!-- Категории -->
    @foreach($categories as $category)
    <url>
        <loc>{{ route('shop.index', ['categories' => $category->id]) }}</loc>
        <lastmod>{{ $category->updated_at->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    
    <!-- Товары -->
    @foreach($products as $product)
    <url>
        <loc>{{ route('shop.product.details', $product->slug) }}</loc>
        <lastmod>{{ $product->updated_at->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    @endforeach
    
    <!-- Бренды -->
    @foreach($brands as $brand)
    <url>
        <loc>{{ route('shop.index', ['brands' => $brand->id]) }}</loc>
        <lastmod>{{ $brand->updated_at->toDateString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
</urlset>