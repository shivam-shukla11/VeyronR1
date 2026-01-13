@extends('layouts.app')

@section('title', 'My Account — VOGUE')

@push('styles')
<style>
.account-layout { display: grid; grid-template-columns: 250px 1fr; gap: 30px; padding: 30px 0; }
.account-sidebar { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); height: fit-content; }
.account-content { background: #fff; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }

.user-info { text-align: center; padding-bottom: 20px; border-bottom: 1px solid #eee; margin-bottom: 20px; }
.user-avatar { width: 80px; height: 80px; border-radius: 50%; background: #222; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 15px; }
.user-name { font-weight: 700; font-size: 1.2rem; }
.user-email { color: #888; font-size: 0.9rem; }

.nav-links a { display: block; padding: 12px 15px; margin-bottom: 8px; border-radius: 8px; color: #333; text-decoration: none; transition: 0.3s; }
.nav-links a:hover, .nav-links a.active { background: #f5f5f5; color: #222; }

.orders-list { }
.order-card { border: 1px solid #eee; border-radius: 12px; padding: 20px; margin-bottom: 15px; }
.order-header { display: flex; justify-content: space-between; margin-bottom: 15px; }
.order-id { font-weight: 700; }
.order-status { padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; }
.status-pending { background: #fef3c7; color: #92400e; }
.status-processing { background: #dbeafe; color: #1e40af; }
.status-shipped { background: #e0e7ff; color: #3730a3; }
.status-delivered { background: #d1fae5; color: #065f46; }
.status-cancelled { background: #fee2e2; color: #991b1b; }

@media (max-width: 768px) {
    .account-layout { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="account-layout">
        <aside class="account-sidebar">
            <div class="user-info">
                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-email">{{ $user->email }}</div>
            </div>
            <nav class="nav-links">
                <a href="{{ route('account.index') }}" class="active">My Orders</a>
                <a href="{{ route('wishlist.index') }}">Wishlist</a>
                <a href="{{ route('logout') }}">Logout</a>
            </nav>
        </aside>

        <div class="account-content">
            <h2 style="margin-bottom: 20px;">My Orders</h2>

            @if($orders->count() > 0)
                <div class="orders-list">
                    @foreach($orders as $order)
                        <div class="order-card">
                            <div class="order-header">
                                <span class="order-id">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                <span class="order-status status-{{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; color:#666;">
                                <span>{{ $order->created_at->format('d M Y, h:i A') }}</span>
                                <span style="font-weight:700; color:#222;">₹{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <a href="{{ route('account.order.view', $order->id) }}" style="display:inline-block; margin-top:15px; color:#222; text-decoration:underline;">View Details →</a>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align:center; padding:50px;">
                    <p style="color:#888;">You haven't placed any orders yet.</p>
                    <a href="{{ route('products.index') }}" style="color:#222; text-decoration:underline;">Start Shopping</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
