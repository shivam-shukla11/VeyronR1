<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update([
            'order_status' => $request->order_status,
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}
