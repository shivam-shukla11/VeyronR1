@extends('layouts.admin')

@section('title', 'Orders — Admin')

@push('styles')
<style>
.orders-table { width: 100%; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.orders-table th, .orders-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
.orders-table th { background: #f9fafb; font-weight: 600; color: #666; }
.status-badge { padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; }
.status-pending { background: #fef3c7; color: #92400e; }
.status-processing { background: #dbeafe; color: #1e40af; }
.status-shipped { background: #e0e7ff; color: #3730a3; }
.status-delivered { background: #d1fae5; color: #065f46; }
.status-cancelled { background: #fee2e2; color: #991b1b; }
.view-btn { color: #3b82f6; text-decoration: none; }
.view-btn:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<h2 style="margin-bottom: 25px;">Orders</h2>

<table class="orders-table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->email }}</td>
                <td>₹{{ number_format($order->total_amount, 2) }}</td>
                <td>{{ strtoupper($order->payment_method) }}</td>
                <td><span class="status-badge status-{{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span></td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td><a href="{{ route('admin.orders.show', $order->id) }}" class="view-btn">View</a></td>
            </tr>
        @empty
            <tr>
                <td colspan="8" style="text-align:center; padding:30px; color:#888;">No orders yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
