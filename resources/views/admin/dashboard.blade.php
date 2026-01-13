@extends('layouts.admin')

@section('title', 'Admin Dashboard — VOGUE')

@push('styles')
<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    text-align: center;
}

.stat-card .icon {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.stat-card .value {
    font-size: 2rem;
    font-weight: 700;
    color: #222;
}

.stat-card .label {
    color: #888;
    font-size: 0.95rem;
    margin-top: 5px;
}

.stat-orders .icon { color: #3b82f6; }
.stat-sales .icon { color: #10b981; }
.stat-products .icon { color: #f59e0b; }
.stat-users .icon { color: #8b5cf6; }

.recent-orders {
    background: #fff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.recent-orders h3 {
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
}

.orders-table th, .orders-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.orders-table th {
    font-weight: 600;
    color: #666;
    font-size: 0.9rem;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
}

.status-pending { background: #fef3c7; color: #92400e; }
.status-processing { background: #dbeafe; color: #1e40af; }
.status-delivered { background: #d1fae5; color: #065f46; }

@media (max-width: 1024px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endpush

@section('content')
<h2 style="margin-bottom: 25px;">Dashboard Overview</h2>

<div class="stats-grid">
    <div class="stat-card stat-orders">
        <div class="icon"><span class="material-icons" style="font-size:inherit;">shopping_cart</span></div>
        <div class="value">{{ $totalOrders }}</div>
        <div class="label">Total Orders</div>
    </div>
    <div class="stat-card stat-sales">
        <div class="icon"><span class="material-icons" style="font-size:inherit;">payments</span></div>
        <div class="value">₹{{ number_format($totalSales, 0) }}</div>
        <div class="label">Total Sales</div>
    </div>
    <div class="stat-card stat-products">
        <div class="icon"><span class="material-icons" style="font-size:inherit;">inventory</span></div>
        <div class="value">{{ $totalProducts }}</div>
        <div class="label">Products</div>
    </div>
    <div class="stat-card stat-users">
        <div class="icon"><span class="material-icons" style="font-size:inherit;">people</span></div>
        <div class="value">{{ $totalUsers }}</div>
        <div class="label">Users</div>
    </div>
</div>

<div class="recent-orders">
    <h3>Recent Orders</h3>
    @if($recentOrders->count() > 0)
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                    <tr>
                        <td>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $order->name }}</td>
                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                        <td><span class="status-badge status-{{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span></td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td><a href="{{ route('admin.orders.show', $order->id) }}" style="color:#3b82f6;">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="color:#888; text-align:center; padding:30px;">No orders yet.</p>
    @endif
</div>
@endsection
