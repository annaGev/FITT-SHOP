<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    // Цвета фона для плейсхолдер-изображений
    private array $colors = [
        [30, 30, 30],    // чёрный
        [220, 53, 69],   // красный
        [0, 123, 255],   // синий
        [40, 167, 69],   // зелёный
        [255, 193, 7],   // жёлтый
        [111, 66, 193],  // фиолетовый
        [23, 162, 184],  // бирюзовый
        [253, 126, 20],  // оранжевый
    ];

    private array $brands = [
        ['name' => 'Nike',         'slug' => 'nike'],
        ['name' => 'Adidas',       'slug' => 'adidas'],
        ['name' => 'Zara',         'slug' => 'zara'],
        ['name' => 'H&M',          'slug' => 'h-m'],
        ['name' => 'Gucci',        'slug' => 'gucci'],
        ['name' => 'Calvin Klein', 'slug' => 'calvin-klein'],
        ['name' => "Levi's",       'slug' => 'levis'],
        ['name' => 'Prada',        'slug' => 'prada'],
    ];

    public function run(): void
    {
        $uploadPath = public_path('uploads/brands');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        foreach ($this->brands as $index => $brandData) {
            $fileName = Str::slug($brandData['slug']) . '_placeholder.png';
            $filePath = $uploadPath . '/' . $fileName;

            if (!file_exists($filePath)) {
                $this->createPlaceholderImage(
                    $filePath,
                    124, 124,
                    $this->colors[$index % count($this->colors)],
                    $brandData['name']
                );
            }

            Brand::updateOrCreate(
                ['slug' => $brandData['slug']],
                [
                    'name'  => $brandData['name'],
                    'slug'  => $brandData['slug'],
                    'image' => $fileName,
                ]
            );
        }

        $this->command->info('✅ Brands seeded: ' . count($this->brands));
    }

    /**
     * Создаёт PNG-плейсхолдер с текстом по центру через GD.
     */
    private function createPlaceholderImage(
        string $path,
        int $width,
        int $height,
        array $bgRgb,
        string $label
    ): void {
        if (!extension_loaded('gd')) {
            // GD недоступен — создаём пустой файл, чтобы не ломать БД
            file_put_contents($path, '');
            return;
        }

        $img = imagecreatetruecolor($width, $height);

        $bg   = imagecolorallocate($img, $bgRgb[0], $bgRgb[1], $bgRgb[2]);
        $text = imagecolorallocate($img, 255, 255, 255);

        imagefill($img, 0, 0, $bg);

        // Центрируем первые 8 символов названия
        $shortLabel = strtoupper(mb_substr($label, 0, 8));
        $font       = 3; // встроенный шрифт GD
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