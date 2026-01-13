<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shipping = $subtotal > 999 ? 0 : 50;
        $total = $subtotal + $shipping;

        return view('shop.checkout', compact('cart', 'subtotal', 'shipping', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'pincode' => 'required|string',
            'payment_method' => 'required|in:cod,online',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $shipping = $subtotal > 999 ? 0 : 50;
        $total = $subtotal + $shipping;

        $order = Order::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'pending',
            'order_status' => 'pending',
            'total_amount' => $total,
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'size' => $item['size'] ?? null,
            ]);
        }

        // Clear cart
        session()->forget(['cart', 'cart_count']);

        return redirect()->route('order.success', $order->id);
    }

    public function success($orderId)
    {
        $order = Order::with('items')->findOrFail($orderId);
        return view('shop.order-success', compact('order'));
    }
}
