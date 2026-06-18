<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status', 1)->get()->take(3);
        $categories = Category::OrderBy('name')->get();
        $sale_products = Product::whereNotNull('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->get()->take(8);
        $fproducts = Product::where('featured', 1)->get()->take(8);
        return view('index', compact('slides', 'categories', 'sale_products', 'fproducts'));
    }
    public function contact()
    {
        return view('contact');
    }
    public function about()
    {
        return view('about');
    }
    public function contact_store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'comment' => 'required'
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();
        return redirect()->back()->with('success', 'Ваше сообшение успешно отправлено');
    }
    // поиск
    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->get()->take(8);
        return response()->json($results);
    }
    public function sitemap()
    {
        $products = Product::all();
        $categories = Category::all();
        $brands = Brand::all();
        $pages = [
            ['url' => route('home.index'), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['url' => route('shop.index'), 'changefreq' => 'hourly', 'priority' => '0.9'],
            ['url' => route('home.about.us'), 'changefreq' => 'weekly', 'priority' => '0.6'],
            ['url' => route('home.contact'), 'changefreq' => 'weekly', 'priority' => '0.6'],
        ];
        return response()->view('sitemap.simple', compact('products', 'categories', 'brands', 'pages'))
            ->header('Content-Type', 'application/xml');
    }
}
