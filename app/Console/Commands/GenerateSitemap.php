<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class GenerateSitemap extends Command
{
    /**
     * Имя и сигнатура команды
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * Описание команды
     *
     * @var string
     */
    protected $description = 'Генерирует sitemap.xml для сайта';

    /**
     * Выполнить команду
     */
    public function handle()
    {
        $this->info('Начинаю генерацию sitemap.xml...');
        
        // Получаем все данные
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
        
        // Статические страницы
        $staticPages = [
            ['loc' => route('home.index'), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => route('shop.index'), 'priority' => '0.9', 'changefreq' => 'hourly'],
            ['loc' => route('home.about.us'), 'priority' => '0.6', 'changefreq' => 'weekly'],
            ['loc' => route('home.contact'), 'priority' => '0.6', 'changefreq' => 'weekly'],
        ];
        
        // Начинаем формировать XML
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        
        // Добавляем статические страницы
        foreach ($staticPages as $page) {
            $xml .= $this->createUrlEntry(
                $page['loc'],
                now()->toDateString(),
                $page['changefreq'],
                $page['priority']
            );
        }
        
        // Добавляем категории
        foreach ($categories as $category) {
            $xml .= $this->createUrlEntry(
                route('shop.index', ['categories' => $category->id]),
                $category->updated_at->toDateString(),
                'weekly',
                '0.8'
            );
        }
        
        // Добавляем товары
        foreach ($products as $product) {
            $xml .= $this->createUrlEntry(
                route('shop.product.details', $product->slug),
                $product->updated_at->toDateString(),
                'weekly',
                '0.9'
            );
        }
        
        // Добавляем бренды
        foreach ($brands as $brand) {
            $xml .= $this->createUrlEntry(
                route('shop.index', ['brands' => $brand->id]),
                $brand->updated_at->toDateString(),
                'monthly',
                '0.5'
            );
        }
        
        $xml .= '</urlset>';
        
        // Сохраняем файл в public директорию
        file_put_contents(public_path('sitemap.xml'), $xml);
        
        $this->info('✅ Sitemap успешно создан: ' . public_path('sitemap.xml'));
        $this->info('📊 Всего URL: ' . (count($staticPages) + $categories->count() + $products->count() + $brands->count()));
        
        return Command::SUCCESS;
    }
    
    /**
     * Создает запись URL для sitemap
     */
    private function createUrlEntry($loc, $lastmod, $changefreq, $priority)
    {
        $entry = "  <url>\n";
        $entry .= "    <loc>" . htmlspecialchars($loc) . "</loc>\n";
        $entry .= "    <lastmod>" . $lastmod . "</lastmod>\n";
        $entry .= "    <changefreq>" . $changefreq . "</changefreq>\n";
        $entry .= "    <priority>" . $priority . "</priority>\n";
        $entry .= "  </url>\n";
        
        return $entry;
    }
}