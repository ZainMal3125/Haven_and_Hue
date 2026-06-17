<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('primaryImage', 'category')->latest()->take(8)->get();
        $categories = Category::all();
        return view('buyer.home', compact('featuredProducts', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('images', 'category', 'seller');
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();
        return view('buyer.products.show', compact('product', 'relatedProducts'));
    }

    public function category(Category $category)
    {
        $products = $category->products()->paginate(12);
        return view('buyer.products.index', compact('products', 'category'));
    }
}
