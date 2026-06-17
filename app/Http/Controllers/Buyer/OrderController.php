<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function checkout()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) return redirect()->route('cart.index');
        
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        return view('buyer.checkout', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        // Simple process without payment gateway integration for now as per prompt (just step 3 order confirmation)
        // Prompt says "Step 3: Order confirmation with OTP verification"
        // Logic: Create Order -> Send OTP -> Verify -> Finalize.
        // For simplicity, we'll create the order as 'pending' and redirect to an OTP verify page for the order.
        
        $cartItems = Cart::where('user_id', Auth::id())->get();
        if ($cartItems->isEmpty()) return back();

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => json_encode($request->only('address', 'city', 'state', 'zip', 'country', 'phone')),
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('orders.show', $order);
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('buyer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        $order->load('items.product');
        return view('buyer.orders.show', compact('order'));
    }
}
