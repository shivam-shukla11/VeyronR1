@extends('layouts.admin')

@section('title', 'Order Details — Admin')

@push('styles')
<style>
.order-card { background: #fff; border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); margin-bottom: 25px; }
.order-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
.order-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
.info-group { margin-bottom: 15px; }
.info-label { color: #888; font-size: 0.9rem; margin-bottom: 5px; }
.info-value { font-weight: 600; color: #222; }
.items-table { width: 100%; margin-top: 20px; }
.items-table th, .items-table td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
.items-table th { color: #888; font-weight: 600; }
.status-form { display: flex; gap: 10px; align-items: center; }
.status-form select { padding: 10px; border: 1px solid #ddd; border-radius: 8px; }
.status-form button { background: #222; color: #fff; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; }
</style>
@endpush

@section('content')
<h2 style="margin-bottom: 25px;">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>

<div class="order-card">
    <div class="order-header">
        <div>
            <span style="color:#888;">Order Date:</span>
            <strong>{{ $order->created_at->format('d M Y, h:i A') }}</strong>
        </div>
        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="status-form">
            @csrf
            <select name="order_status">
                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit">Update Status</button>
        </form>
    </div>

    <div class="order-grid">
        <div>
            <h4 style="margin-bottom: 15px;">Customer Information</h4>
            <div class="info-group">
                <div class="info-label">Name</div>
                <div class="info-value">{{ $order->name }}</div>
            </div>
            <div class="info-group">
                <div class="info-label">Email</div>
                <div class="info-value">{{ $order->email }}</div>
            </div>
            <div class="info-group">
                <div class="info-label">Mobile</div>
                <div class="info-value">{{ $order->mobile }}</div>
            </div>
        </div>
        <div>
            <h4 style="margin-bottom: 15px;">Shipping Address</h4>
            <div class="info-group">
                <div class="info-value">{{ $order->address }}</div>
                <div class="info-value">{{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</div>
            </div>
            <div class="info-group">
                <div class="info-label">Payment Method</div>
                <div class="info-value">{{ $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</div>
            </div>
        </div>
    </div>
</div>

<div class="order-card">
    <h4>Order Items</h4>
    <table class="items-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->size ?? '-' }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right; font-weight:700;">Grand Total:</td>
                <td style="font-weight:700; font-size:1.2rem;">₹{{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>

<a href="{{ route('admin.orders.index') }}" style="color:#3b82f6;">← Back to Orders</a>
@endsection
