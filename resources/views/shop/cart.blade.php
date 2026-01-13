@extends('layouts.app')

@section('title', 'Shopping Cart — VOGUE')

@push('styles')
<style>
.cart-layout { display:grid; grid-template-columns:1fr 350px; gap:30px; padding:30px 0; }
.cart-items { background:#fff; border-radius:12px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,0.08); }
.cart-summary { background:#fff; border-radius:12px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,0.08); height:fit-content; position:sticky; top:100px; }

.cart-item { display:flex; gap:20px; padding:20px 0; border-bottom:1px solid #eee; }
.cart-item:last-child { border-bottom:none; }
.cart-item img { width:120px; height:150px; object-fit:cover; border-radius:8px; }
.cart-item-info { flex:1; display:flex; flex-direction:column; gap:8px; }
.cart-item-name { font-weight:600; font-size:1.1rem; color:#222; }
.cart-item-meta { color:#888; font-size:0.9rem; }
.cart-item-price { font-weight:700; font-size:1.1rem; }
.cart-item-actions { display:flex; align-items:center; gap:15px; margin-top:auto; }

.qty-control { display:flex; align-items:center; gap:10px; }
.qty-btn { width:32px; height:32px; border:1px solid #ddd; background:#fff; border-radius:6px; cursor:pointer; }
.qty-value { font-weight:600; }

.remove-btn { color:#dc2626; background:none; border:none; cursor:pointer; font-size:0.9rem; }
.remove-btn:hover { text-decoration:underline; }

.summary-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #eee; }
.summary-total { font-size:1.3rem; font-weight:700; border-bottom:none; }

.checkout-btn {
    width:100%; padding:15px; background:#222; color:#fff; border:none;
    border-radius:8px; font-size:1rem; font-weight:600; cursor:pointer; margin-top:20px;
}
.checkout-btn:hover { background:#444; }

.empty-cart { text-align:center; padding:50px; }
.empty-cart a { color:#222; text-decoration:underline; }

@media (max-width: 768px) {
    .cart-layout { grid-template-columns:1fr; }
}
</style>
@endpush

@section('content')
<div class="container">
    <h1 style="margin-bottom:20px;">Shopping Cart</h1>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:12px; border-radius:8px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="cart-layout">
            <div class="cart-items">
                @foreach($cart as $id => $item)
                    <div class="cart-item">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}">
                        <div class="cart-item-info">
                            <span class="cart-item-name">{{ $item['name'] }}</span>
                            <span class="cart-item-meta">
                                @if(!empty($item['size'])) Size: {{ $item['size'] }} @endif
                            </span>
                            <span class="cart-item-price">₹{{ number_format($item['price'], 2) }}</span>
                            
                            <div class="cart-item-actions">
                                <form action="{{ route('cart.update') }}" method="POST" class="qty-control">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <button type="submit" name="action" value="decrease" class="qty-btn">-</button>
                                    <span class="qty-value">{{ $item['quantity'] }}</span>
                                    <button type="submit" name="action" value="increase" class="qty-btn">+</button>
                                </form>
                                
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $id }}">
                                    <button type="submit" class="remove-btn">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <h3 style="margin-bottom:20px;">Order Summary</h3>
                
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>{{ $shipping > 0 ? '₹'.number_format($shipping, 2) : 'FREE' }}</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total</span>
                    <span>₹{{ number_format($total, 2) }}</span>
                </div>

                <a href="{{ route('checkout.index') }}">
                    <button class="checkout-btn">Proceed to Checkout</button>
                </a>
            </div>
        </div>
    @else
        <div class="empty-cart">
            <h2>Your cart is empty</h2>
            <p style="color:#888; margin:20px 0;">Looks like you haven't added anything yet.</p>
            <a href="{{ route('products.index') }}">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection
