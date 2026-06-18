<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    // -------------------------------------------------------
    // Данные товаров: 3 товара × 8 категорий = 24 продукта
    // -------------------------------------------------------
    private function products(): array
    {
        return [

            // ── ПЛАТЬЯ ──────────────────────────────────────────
            [
                'name'              => 'Летнее платье с цветочным принтом',
                'category'          => 'platya',
                'brand'             => 'zara',
                'regular_price'     => 3990.00,
                'sale_price'        => 2990.00,
                'SKU'               => 'DR-001',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 50,
                'colors'            => '#d76b67,#e6ae95,#bfdcc4',
                'sizes'             => 'XS,S,M,L,XL',
                'short_description' => 'Лёгкое летнее платье с ярким цветочным принтом.',
                'description'       => '<p>Лёгкое летнее платье с ярким цветочным принтом. Идеально для прогулок и отдыха. Состав: 100% вискоза.</p>',
                'bg'                => [214, 107, 103],
            ],
            [
                'name'              => 'Коктейльное платье миди',
                'category'          => 'platya',
                'brand'             => 'gucci',
                'regular_price'     => 12900.00,
                'sale_price'        => null,
                'SKU'               => 'DR-002',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 20,
                'colors'            => '#282828,#0a2472',
                'sizes'             => 'XS,S,M,L',
                'short_description' => 'Элегантное коктейльное платье длины миди.',
                'description'       => '<p>Элегантное коктейльное платье длины миди. Подходит для торжественных мероприятий. Состав: 70% полиэстер, 30% эластан.</p>',
                'bg'                => [40, 40, 40],
            ],
            [
                'name'              => 'Офисное платье-футляр',
                'category'          => 'platya',
                'brand'             => 'calvin-klein',
                'regular_price'     => 5490.00,
                'sale_price'        => 4490.00,
                'SKU'               => 'DR-003',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 35,
                'colors'            => '#282828,#b1d6e8,#bababa',
                'sizes'             => 'S,M,L,XL,XXL',
                'short_description' => 'Строгое офисное платье-футляр классического кроя.',
                'description'       => '<p>Строгое офисное платье-футляр классического кроя. Незаменимо для деловых встреч. Состав: 95% хлопок, 5% эластан.</p>',
                'bg'                => [177, 214, 232],
            ],

            // ── ДЖИНСЫ ──────────────────────────────────────────
            [
                'name'              => "Джинсы slim fit Levi's 511",
                'category'          => 'dzhinsy',
                'brand'             => 'levis',
                'regular_price'     => 4990.00,
                'sale_price'        => 3790.00,
                'SKU'               => 'JN-001',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 80,
                'colors'            => '#0a2472,#282828,#9c7539',
                'sizes'             => 'S,M,L,XL,XXL',
                'short_description' => 'Классические джинсы slim fit от Levi\'s.',
                'description'       => "<p>Классические джинсы slim fit от Levi's модель 511. Умеренная посадка, зауженный крой. Состав: 99% хлопок, 1% эластан.</p>",
                'bg'                => [10, 36, 114],
            ],
            [
                'name'              => 'Джинсы wide leg с высокой посадкой',
                'category'          => 'dzhinsy',
                'brand'             => 'h-m',
                'regular_price'     => 2990.00,
                'sale_price'        => null,
                'SKU'               => 'JN-002',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 60,
                'colors'            => '#0a2472,#bababa',
                'sizes'             => 'XS,S,M,L,XL',
                'short_description' => 'Широкие джинсы с высокой посадкой — тренд сезона.',
                'description'       => '<p>Широкие джинсы с высокой посадкой. Прямой широкий крой, идеально сочетается с укороченными топами. Состав: 98% хлопок, 2% эластан.</p>',
                'bg'                => [186, 186, 186],
            ],
            [
                'name'              => 'Чёрные скинни-джинсы',
                'category'          => 'dzhinsy',
                'brand'             => 'zara',
                'regular_price'     => 3490.00,
                'sale_price'        => 2490.00,
                'SKU'               => 'JN-003',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 45,
                'colors'            => '#282828',
                'sizes'             => 'XS,S,M,L,XL,XXL',
                'short_description' => 'Классические чёрные скинни-джинсы.',
                'description'       => '<p>Классические чёрные скинни-джинсы. Облегающий крой подчёркивает фигуру. Состав: 97% хлопок, 3% эластан.</p>',
                'bg'                => [40, 40, 40],
            ],

            // ── РУБАШКИ ─────────────────────────────────────────
            [
                'name'              => 'Классическая белая рубашка',
                'category'          => 'rubashki',
                'brand'             => 'calvin-klein',
                'regular_price'     => 3290.00,
                'sale_price'        => null,
                'SKU'               => 'SH-001',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 100,
                'colors'            => '#bababa',
                'sizes'             => 'S,M,L,XL,XXL',
                'short_description' => 'Безупречная классическая белая рубашка.',
                'description'       => '<p>Безупречная классическая белая рубашка из хлопка. Подходит как для офиса, так и для casual образа. Состав: 100% хлопок.</p>',
                'bg'                => [200, 200, 200],
            ],
            [
                'name'              => 'Фланелевая рубашка в клетку',
                'category'          => 'rubashki',
                'brand'             => 'h-m',
                'regular_price'     => 1990.00,
                'sale_price'        => 1490.00,
                'SKU'               => 'SH-002',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 55,
                'colors'            => '#d29b48,#0a2472,#d76b67',
                'sizes'             => 'S,M,L,XL,XXL',
                'short_description' => 'Тёплая фланелевая рубашка в крупную клетку.',
                'description'       => '<p>Тёплая фланелевая рубашка в крупную клетку. Идеальна для casual образа в холодное время. Состав: 100% фланель.</p>',
                'bg'                => [210, 155, 72],
            ],
            [
                'name'              => 'Льняная рубашка оверсайз',
                'category'          => 'rubashki',
                'brand'             => 'zara',
                'regular_price'     => 2790.00,
                'sale_price'        => null,
                'SKU'               => 'SH-003',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 40,
                'colors'            => '#bfdcc4,#d29b48,#bababa',
                'sizes'             => 'S,M,L,XL',
                'short_description' => 'Свободная льняная рубашка для летнего образа.',
                'description'       => '<p>Свободная льняная рубашка оверсайз. Натуральный материал обеспечивает комфорт в жару. Состав: 100% лён.</p>',
                'bg'                => [191, 220, 196],
            ],

            // ── ОБУВЬ ───────────────────────────────────────────
            [
                'name'              => 'Кроссовки Nike Air Max 270',
                'category'          => 'obuv',
                'brand'             => 'nike',
                'regular_price'     => 9990.00,
                'sale_price'        => 7990.00,
                'SKU'               => 'SH-SN-001',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 30,
                'colors'            => '#282828,#d76b67,#0a2472',
                'sizes'             => 'S,M,L,XL',
                'short_description' => 'Популярные кроссовки Nike Air Max 270.',
                'description'       => '<p>Популярные кроссовки Nike Air Max 270 с амортизирующей подошвой. Верх из дышащего материала. Подходят для повседневной носки и лёгкого бега.</p>',
                'bg'                => [30, 30, 30],
            ],
            [
                'name'              => 'Кроссовки Adidas Ultraboost',
                'category'          => 'obuv',
                'brand'             => 'adidas',
                'regular_price'     => 11990.00,
                'sale_price'        => null,
                'SKU'               => 'SH-SN-002',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 25,
                'colors'            => '#282828,#bababa,#b1d6e8',
                'sizes'             => 'S,M,L,XL',
                'short_description' => 'Беговые кроссовки Adidas Ultraboost.',
                'description'       => '<p>Беговые кроссовки Adidas Ultraboost с технологией BOOST. Максимальное возвращение энергии при каждом шаге. Верх из Primeknit.</p>',
                'bg'                => [0, 90, 200],
            ],
            [
                'name'              => 'Классические кожаные туфли',
                'category'          => 'obuv',
                'brand'             => 'gucci',
                'regular_price'     => 24900.00,
                'sale_price'        => null,
                'SKU'               => 'SH-SN-003',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 15,
                'colors'            => '#282828,#9c7539',
                'sizes'             => 'S,M,L,XL',
                'short_description' => 'Роскошные классические кожаные туфли.',
                'description'       => '<p>Роскошные классические кожаные туфли ручной работы. Натуральная кожа высшего качества. Незаменимы для торжественных мероприятий.</p>',
                'bg'                => [156, 117, 57],
            ],

            // ── АКСЕССУАРЫ ──────────────────────────────────────
            [
                'name'              => 'Кожаный ремень Calvin Klein',
                'category'          => 'aksessuary',
                'brand'             => 'calvin-klein',
                'regular_price'     => 2490.00,
                'sale_price'        => 1990.00,
                'SKU'               => 'ACC-001',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 70,
                'colors'            => '#282828,#9c7539',
                'sizes'             => 'S,M,L',
                'short_description' => 'Классический кожаный ремень Calvin Klein.',
                'description'       => '<p>Классический кожаный ремень Calvin Klein. Натуральная кожа, металлическая пряжка. Универсальный аксессуар для любого образа.</p>',
                'bg'                => [40, 40, 40],
            ],
            [
                'name'              => 'Солнцезащитные очки Prada',
                'category'          => 'aksessuary',
                'brand'             => 'prada',
                'regular_price'     => 18900.00,
                'sale_price'        => null,
                'SKU'               => 'ACC-002',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 20,
                'colors'            => '#282828,#9c7539,#d29b48',
                'sizes'             => 'M',
                'short_description' => 'Стильные солнцезащитные очки Prada.',
                'description'       => '<p>Стильные солнцезащитные очки Prada с UV400 защитой. Ацетатная оправа, поляризованные линзы. Икона стиля на каждое лето.</p>',
                'bg'                => [111, 66, 193],
            ],
            [
                'name'              => 'Шёлковый платок Gucci',
                'category'          => 'aksessuary',
                'brand'             => 'gucci',
                'regular_price'     => 7990.00,
                'sale_price'        => 6490.00,
                'SKU'               => 'ACC-003',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 30,
                'colors'            => '#d76b67,#d29b48,#bfdcc4',
                'sizes'             => 'M',
                'short_description' => 'Роскошный шёлковый платок Gucci.',
                'description'       => '<p>Роскошный шёлковый платок Gucci с фирменным принтом. Натуральный шёлк. Может использоваться как аксессуар для волос или шеи.</p>',
                'bg'                => [215, 107, 103],
            ],

            // ── СПОРТИВНАЯ ОДЕЖДА ────────────────────────────────
            [
                'name'              => 'Спортивный костюм Nike Dri-FIT',
                'category'          => 'sportivnaya-odezhda',
                'brand'             => 'nike',
                'regular_price'     => 6990.00,
                'sale_price'        => 5490.00,
                'SKU'               => 'SP-001',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 45,
                'colors'            => '#282828,#d76b67,#0a2472',
                'sizes'             => 'S,M,L,XL,XXL',
                'short_description' => 'Функциональный спортивный костюм Nike Dri-FIT.',
                'description'       => '<p>Функциональный спортивный костюм Nike с технологией Dri-FIT. Отводит влагу, сохраняет прохладу. Идеален для тренировок и повседневного использования.</p>',
                'bg'                => [220, 53, 69],
            ],
            [
                'name'              => 'Леггинсы Adidas Believe This',
                'category'          => 'sportivnaya-odezhda',
                'brand'             => 'adidas',
                'regular_price'     => 3490.00,
                'sale_price'        => null,
                'SKU'               => 'SP-002',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 60,
                'colors'            => '#282828,#0a2472,#bfdcc4',
                'sizes'             => 'XS,S,M,L,XL',
                'short_description' => 'Компрессионные леггинсы Adidas для тренировок.',
                'description'       => '<p>Компрессионные леггинсы Adidas Believe This с поддерживающей посадкой. Технология AEROREADY удерживает сухость. Высокий пояс для комфорта.</p>',
                'bg'                => [0, 100, 210],
            ],
            [
                'name'              => 'Спортивная куртка на молнии Nike',
                'category'          => 'sportivnaya-odezhda',
                'brand'             => 'nike',
                'regular_price'     => 5990.00,
                'sale_price'        => 4990.00,
                'SKU'               => 'SP-003',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 35,
                'colors'            => '#282828,#d76b67',
                'sizes'             => 'S,M,L,XL,XXL',
                'short_description' => 'Лёгкая спортивная куртка Nike на молнии.',
                'description'       => '<p>Лёгкая спортивная куртка Nike на молнии. Ветрозащитный материал, удобные карманы. Подходит для пробежек и активного отдыха.</p>',
                'bg'                => [30, 30, 30],
            ],

            // ── ВЕРХНЯЯ ОДЕЖДА ──────────────────────────────────
            [
                'name'              => 'Пальто из шерсти Zara',
                'category'          => 'verhnyaya-odezhda',
                'brand'             => 'zara',
                'regular_price'     => 8990.00,
                'sale_price'        => 6990.00,
                'SKU'               => 'OW-001',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 25,
                'colors'            => '#282828,#bababa,#9c7539',
                'sizes'             => 'XS,S,M,L,XL',
                'short_description' => 'Элегантное шерстяное пальто от Zara.',
                'description'       => '<p>Элегантное пальто из смеси шерсти от Zara. Классический двубортный крой, подходит для офиса и прогулок. Состав: 60% шерсть, 40% полиэстер.</p>',
                'bg'                => [100, 100, 100],
            ],
            [
                'name'              => 'Кожаная куртка Calvin Klein',
                'category'          => 'verhnyaya-odezhda',
                'brand'             => 'calvin-klein',
                'regular_price'     => 14990.00,
                'sale_price'        => null,
                'SKU'               => 'OW-002',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 18,
                'colors'            => '#282828,#9c7539',
                'sizes'             => 'S,M,L,XL',
                'short_description' => 'Классическая кожаная куртка Calvin Klein.',
                'description'       => '<p>Классическая кожаная куртка Calvin Klein. Натуральная телячья кожа, косая молния. Неизменная классика гардероба.</p>',
                'bg'                => [40, 40, 40],
            ],
            [
                'name'              => 'Пуховик Adidas зимний',
                'category'          => 'verhnyaya-odezhda',
                'brand'             => 'adidas',
                'regular_price'     => 9490.00,
                'sale_price'        => 7990.00,
                'SKU'               => 'OW-003',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 30,
                'colors'            => '#282828,#0a2472,#d76b67',
                'sizes'             => 'S,M,L,XL,XXL',
                'short_description' => 'Тёплый зимний пуховик Adidas.',
                'description'       => '<p>Тёплый зимний пуховик Adidas с наполнением из синтетического пуха. Водоотталкивающее покрытие, удобный капюшон. Подходит для температур до -20°C.</p>',
                'bg'                => [0, 80, 190],
            ],

            // ── ТРИКОТАЖ ─────────────────────────────────────────
            [
                'name'              => 'Шерстяной свитер оверсайз H&M',
                'category'          => 'trikotazh',
                'brand'             => 'h-m',
                'regular_price'     => 2490.00,
                'sale_price'        => 1990.00,
                'SKU'               => 'KN-001',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 55,
                'colors'            => '#bababa,#9c7539,#bfdcc4',
                'sizes'             => 'XS,S,M,L,XL,XXL',
                'short_description' => 'Уютный шерстяной свитер оверсайз от H&M.',
                'description'       => '<p>Уютный шерстяной свитер оверсайз от H&M. Мягкая фактура, свободный крой. Состав: 80% шерсть, 20% полиамид.</p>',
                'bg'                => [185, 185, 185],
            ],
            [
                'name'              => 'Кашемировый кардиган Prada',
                'category'          => 'trikotazh',
                'brand'             => 'prada',
                'regular_price'     => 32900.00,
                'sale_price'        => null,
                'SKU'               => 'KN-002',
                'stock_status'      => 'instock',
                'featured'          => true,
                'quantity'          => 12,
                'colors'            => '#bababa,#282828,#d29b48',
                'sizes'             => 'XS,S,M,L',
                'short_description' => 'Роскошный кашемировый кардиган Prada.',
                'description'       => '<p>Роскошный кашемировый кардиган Prada. Мягкий монгольский кашемир, классические пуговицы. Символ утончённого стиля. Состав: 100% кашемир.</p>',
                'bg'                => [111, 66, 193],
            ],
            [
                'name'              => 'Хлопковый джемпер Zara',
                'category'          => 'trikotazh',
                'brand'             => 'zara',
                'regular_price'     => 1990.00,
                'sale_price'        => 1490.00,
                'SKU'               => 'KN-003',
                'stock_status'      => 'instock',
                'featured'          => false,
                'quantity'          => 70,
                'colors'            => '#b1d6e8,#bfdcc4,#e6ae95',
                'sizes'             => 'XS,S,M,L,XL,XXL',
                'short_description' => 'Лёгкий хлопковый джемпер Zara на каждый день.',
                'description'       => '<p>Лёгкий хлопковый джемпер Zara. Мягкий трикотаж, прямой крой. Базовый элемент гардероба для любого сезона. Состав: 100% хлопок.</p>',
                'bg'                => [177, 214, 232],
            ],
        ];
    }

    // -------------------------------------------------------

    public function run(): void
    {
        $this->ensureDirectories();

        // Кэшируем lookup-таблицы, чтобы не делать N запросов
        $categories = Category::pluck('id', 'slug');
        $brands     = Brand::pluck('id', 'slug');

        foreach ($this->products() as $data) {
            $categoryId = $categories[$data['category']] ?? null;
            $brandId    = $brands[$data['brand']]    ?? null;

            if (!$categoryId || !$brandId) {
                $this->command->warn(
                    "⚠️  Пропущен товар «{$data['name']}»: категория «{$data['category']}» или бренд «{$data['brand']}» не найдены."
                );
                continue;
            }

            $slug = Str::slug($data['name']);

            // Главное изображение
            $mainImage = $slug . '_main.png';
            $this->createProductImage(
                public_path('uploads/products/' . $mainImage),
                540, 689,
                $data['bg'],
                $data['name']
            );
            // Миниатюра
            $this->createProductImage(
                public_path('uploads/products/thumbnails/' . $mainImage),
                104, 104,
                $data['bg'],
                $data['name']
            );

            // Галерея — 2 доп. изображения
            $galleryFiles = [];
            foreach ([1, 2] as $i) {
                $gFile   = $slug . "_gallery_{$i}.png";
                $lighterBg = array_map(fn($c) => min(255, $c + 50), $data['bg']);
                $this->createProductImage(
                    public_path('uploads/products/' . $gFile),
                    540, 689,
                    $lighterBg,
                    $data['name'] . " #{$i}"
                );
                $this->createProductImage(
                    public_path('uploads/products/thumbnails/' . $gFile),
                    104, 104,
                    $lighterBg,
                    $data['name']
                );
                $galleryFiles[] = $gFile;
            }

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'              => $data['name'],
                    'slug'              => $slug,
                    'short_description' => $data['short_description'],
                    'description'       => $data['description'],
                    'regular_price'     => $data['regular_price'],
                    'sale_price'        => $data['sale_price'],
                    'SKU'               => $data['SKU'],
                    'stock_status'      => $data['stock_status'],
                    'featured'          => $data['featured'],
                    'quantity'          => $data['quantity'],
                    'image'             => $mainImage,
                    'images'            => implode(',', $galleryFiles),
                    'colors'            => $data['colors'],
                    'sizes'             => $data['sizes'],
                    'category_id'       => $categoryId,
                    'brand_id'          => $brandId,
                ]
            );
        }

        $this->command->info('✅ Products seeded: ' . count($this->products()));
    }

    // -------------------------------------------------------

    private function ensureDirectories(): void
    {
        foreach ([
            public_path('uploads/products'),
            public_path('uploads/products/thumbnails'),
        ] as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }
    }

    private function createProductImage(
        string $path,
        int    $width,
        int    $height,
        array  $bgRgb,
        string $label
    ): void {
        if (file_exists($path)) {
            return;
        }

        if (!extension_loaded('gd')) {
            file_put_contents($path, '');
            return;
        }

        $img  = imagecreatetruecolor($width, $height);
        $bg   = imagecolorallocate($img, $bgRgb[0], $bgRgb[1], $bgRgb[2]);
        $text = imagecolorallocate($img, 255, 255, 255);

        imagefill($img, 0, 0, $bg);

        // Рамка
        $border = imagecolorallocate($img, 255, 255, 255);
        imagerectangle($img, 4, 4, $width - 5, $height - 5, $border);

        // Текст — первые 14 символов
        $shortLabel = mb_substr($label, 0, 14);
        $font       = 2;
        $charW      = imagefontwidth($font);
        $charH      = imagefontheight($font);
        $textW      = strlen($shortLabel) * $charW;
        $x          = (int)(($width  - $textW) / 2);
        $y          = (int)(($height - $charH) / 2);

        imagestring($img, $font, $x, $y, $shortLabel, $text);
        imagepng($img, $path);
        imagedestroy($img);
    }
}