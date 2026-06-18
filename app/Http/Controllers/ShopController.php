<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    const AVAILABLE_COLORS = [
        '#0a2472', '#d7bb4f', '#282828', '#b1d6e8',
        '#9c7539', '#d29b48', '#e6ae95', '#d76b67',
        '#bababa', '#bfdcc4',
    ];

    const AVAILABLE_SIZES = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

    public function index(Request $request)
    {
        $size        = $request->query('size', 12);
        $order       = $request->query('order', -1);
        $f_brands    = $request->query('brands');
        $f_categories = $request->query('categories');
        $f_colors    = $request->query('colors');
        $f_sizes     = $request->query('sizes');

        $min_price = is_numeric($request->query('min')) ? (float) $request->query('min') : 0;
        $max_price = is_numeric($request->query('max')) ? (float) $request->query('max') : 50000;

        $o_column = 'id';
        $o_order  = 'DESC';

        switch ((int) $order) {
            case 1: $o_column = 'created_at'; $o_order = 'DESC'; break;
            case 2: $o_column = 'created_at'; $o_order = 'ASC';  break;
            case 3: $o_column = 'sale_price';  $o_order = 'ASC';  break;
            case 4: $o_column = 'sale_price';  $o_order = 'DESC'; break;
        }

        $brands     = Brand::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        $query = Product::query();

        // Фильтр по брендам
        if (!empty($f_brands)) {
            $brandIds = array_filter(
                explode(',', $f_brands),
                fn($id) => is_numeric($id) && $id > 0
            );
            if (!empty($brandIds)) {
                $query->whereIn('brand_id', $brandIds);
            }
        }

        // Фильтр по категориям
        if (!empty($f_categories)) {
            $categoryIds = array_filter(
                explode(',', $f_categories),
                fn($id) => is_numeric($id) && $id > 0
            );
            if (!empty($categoryIds)) {
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Фильтр по цветам
        if (!empty($f_colors)) {
            $colorsList = array_filter(array_map('trim', explode(',', $f_colors)));
            if (!empty($colorsList)) {
                $query->where(function ($q) use ($colorsList) {
                    foreach ($colorsList as $color) {
                        $q->orWhere('colors', 'LIKE', '%' . $color . '%');
                    }
                });
            }
        }

        // Фильтр по размерам
        if (!empty($f_sizes)) {
            $sizesList = array_filter(array_map('trim', explode(',', $f_sizes)));
            if (!empty($sizesList)) {
                $query->where(function ($q) use ($sizesList) {
                    foreach ($sizesList as $size) {
                        // Точное совпадение: ,S, или начало строки S, или конец ,S
                        $q->orWhere('sizes', 'LIKE', '%,' . $size . ',%')
                          ->orWhere('sizes', 'LIKE', $size . ',%')
                          ->orWhere('sizes', 'LIKE', '%,' . $size)
                          ->orWhere('sizes', $size);
                    }
                });
            }
        }

        // Фильтр по цене
        $query->where(function ($q) use ($min_price, $max_price) {
            $q->whereBetween('regular_price', [$min_price, $max_price])
              ->orWhereBetween('sale_price', [$min_price, $max_price]);
        });

        $products = $query->orderBy($o_column, $o_order)->paginate($size);

        return view('shop', compact(
            'products', 'size', 'order',
            'brands', 'f_brands',
            'categories', 'f_categories',
            'min_price', 'max_price',
            'f_colors', 'f_sizes'
        ));
    }

    public function product_details($product_slug)
    {
        $product  = Product::where('slug', $product_slug)->first();
        $rproducts = Product::where('slug', '<>', $product_slug)->take(8)->get();
        return view('details', ['product' => $product, 'rproducts' => $rproducts]);
    }
}