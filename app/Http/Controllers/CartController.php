<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shipping = $subtotal > 999 ? 0 : 50;
        $total = $subtotal + $shipping;

        // Update cart count in session
        $cartCount = array_sum(array_column($cart, 'quantity'));
        session(['cart_count' => $cartCount]);

        return view('shop.cart', compact('cart', 'subtotal', 'shipping', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:admin_products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session('cart', []);

        $cartKey = $product->id . '_' . ($request->size ?? 'default');

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'size' => $request->size ?? null,
                'quantity' => $request->quantity,
            ];
        }

        session(['cart' => $cart]);
        
        // Update cart count
        $cartCount = array_sum(array_column($cart, 'quantity'));
        session(['cart_count' => $cartCount]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        $productId = $request->product_id;
        $action = $request->action;

        foreach ($cart as $key => $item) {
            if (strpos($key, $productId . '_') === 0) {
                if ($action === 'increase') {
                    $cart[$key]['quantity']++;
                } elseif ($action === 'decrease') {
                    $cart[$key]['quantity']--;
                    if ($cart[$key]['quantity'] <= 0) {
                        unset($cart[$key]);
                    }
                }
                break;
            }
        }

        session(['cart' => $cart]);
        
        $cartCount = array_sum(array_column($cart, 'quantity'));
        session(['cart_count' => $cartCount]);

        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        $productId = $request->product_id;

        foreach ($cart as $key => $item) {
            if (strpos($key, $productId . '_') === 0) {
                unset($cart[$key]);
                break;
            }
        }

        session(['cart' => $cart]);
        
        $cartCount = array_sum(array_column($cart, 'quantity'));
        session(['cart_count' => $cartCount]);

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}
