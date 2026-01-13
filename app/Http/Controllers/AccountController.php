<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            session(['redirect_after_login' => route('account.index')]);
            return redirect()->route('login');
        }

        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shop.account', compact('user', 'orders'));
    }

    public function orders()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shop.orders', compact('orders'));
    }

    public function orderView($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::with('items')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('shop.order-view', compact('order'));
    }
}
