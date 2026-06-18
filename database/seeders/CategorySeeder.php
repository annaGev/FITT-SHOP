<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    private array $colors = [
        [220, 53, 69],
        [0, 123, 255],
        [40, 167, 69],
        [255, 193, 7],
        [111, 66, 193],
        [23, 162, 184],
        [253, 126, 20],
        [52, 58, 64],
    ];

    private array $categories = [
        ['name' => 'Платья',             'slug' => 'platya'],
        ['name' => 'Джинсы',             'slug' => 'dzhinsy'],
        ['name' => 'Рубашки',            'slug' => 'rubashki'],
        ['name' => 'Обувь',              'slug' => 'obuv'],
        ['name' => 'Аксессуары',         'slug' => 'aksessuary'],
        ['name' => 'Спортивная одежда',  'slug' => 'sportivnaya-odezhda'],
        ['name' => 'Верхняя одежда',     'slug' => 'verhnyaya-odezhda'],
        ['name' => 'Трикотаж',           'slug' => 'trikotazh'],
    ];

    public function run(): void
    {
        $uploadPath = public_path('uploads/categories');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        foreach ($this->categories as $index => $catData) {
            $fileName = $catData['slug'] . '_placeholder.png';
            $filePath = $uploadPath . '/' . $fileName;

            if (!file_exists($filePath)) {
                $this->createPlaceholderImage(
                    $filePath,
                    124, 124,
                    $this->colors[$index % count($this->colors)],
                    $catData['name']
                );
            }

            Category::updateOrCreate(
                ['slug' => $catData['slug']],
                [
                    'name'      => $catData['name'],
                    'slug'      => $catData['slug'],
                    'image'     => $fileName,
                    'parent_id' => null,
                ]
            );
        }

        $this->command->info('✅ Categories seeded: ' . count($this->categories));
    }

    private function createPlaceholderImage(
        string $path,
        int $width,
        int $height,
        array $bgRgb,
        string $label
    ): void {
        if (!extension_loaded('gd')) {
            file_put_contents($path, '');
            return;
        }

        $img  = imagecreatetruecolor($width, $height);
        $bg   = imagecolorallocate($img, $bgRgb[0], $bgRgb[1], $bgRgb[2]);
        $text = imagecolorallocate($img, 255, 255, 255);

        imagefill($img, 0, 0, $bg);

        $shortLabel = mb_strtoupper(mb_substr($label, 0, 10));
        $font       = 3;
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