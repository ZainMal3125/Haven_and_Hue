<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('seller_id', Auth::id())->with('category')->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'material_type' => $request->material_type ?? 'Wood',
            'dimensions' => $request->dimensions ?? 'N/A',
            'stock' => $request->stock,
            'seller_id' => Auth::id(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        return redirect()->route('seller.products.index')->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        if ($product->seller_id !== Auth::id()) abort(403);
        $categories = Category::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->seller_id !== Auth::id()) abort(403);
        // Add validation and update logic
        $product->update($request->all());
        return redirect()->route('seller.products.index');
    }

    public function destroy(Product $product)
    {
        if ($product->seller_id !== Auth::id()) abort(403);
        $product->delete();
        return back()->with('success', 'Product deleted');
    }

    public function orders()
    {
        $sellerId = Auth::id();
        $orders = \App\Models\Order::whereHas('items', function ($query) use ($sellerId) {
            $query->whereHas('product', function ($q) use ($sellerId) {
                $q->where('seller_id', $sellerId);
            });
        })->with(['items.product' => function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        }, 'user'])->latest()->paginate(10);

        return view('seller.orders', compact('orders'));
    }

    public function confirmOrder(\App\Models\Order $order)
    {
        $sellerId = Auth::id();
        // check if order contains any product from this seller
        $hasProduct = $order->items()->whereHas('product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->exists();

        if (!$hasProduct) {
            abort(403);
        }

        if ($order->status === 'pending') {
            $order->update(['status' => 'confirmed']);
            return back()->with('success', 'Order #' . $order->order_number . ' has been confirmed.');
        }

        return back()->with('error', 'Order cannot be confirmed.');
    }
}
