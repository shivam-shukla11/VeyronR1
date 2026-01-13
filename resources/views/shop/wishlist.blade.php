@extends('layouts.app')

@section('title', 'Wishlist — VOGUE')

@push('styles')
<style>
.wishlist-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
    padding: 30px 0;
}

.wishlist-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    transition: transform 0.3s;
}

.wishlist-card:hover { transform: translateY(-5px); }
.wishlist-card img { width: 100%; height: 280px; object-fit: cover; }
.wishlist-info { padding: 15px; }
.wishlist-name { font-weight: 600; font-size: 1rem; color: #222; }
.wishlist-price { font-weight: 700; font-size: 1.1rem; color: #000; margin-top: 8px; }

.wishlist-actions { display: flex; gap: 10px; padding: 15px; border-top: 1px solid #eee; }
.btn-add-cart, .btn-remove {
    flex: 1; padding: 10px; border: none; border-radius: 8px;
    font-size: 0.9rem; cursor: pointer; transition: 0.3s;
}
.btn-add-cart { background: #222; color: #fff; }
.btn-add-cart:hover { background: #444; }
.btn-remove { background: #f5f5f5; color: #dc2626; }
.btn-remove:hover { background: #fee2e2; }

.empty-wishlist { text-align: center; padding: 80px; }
.empty-wishlist a { color: #222; text-decoration: underline; }
</style>
@endpush

@section('content')
<div class="container">
    <h1 style="margin-bottom: 10px;">My Wishlist</h1>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:12px; border-radius:8px; margin-bottom:20px;">
            {{ session('success') }}
        </div>
    @endif

    @if(count($wishlistItems) > 0)
        <div class="wishlist-grid">
            @foreach($wishlistItems as $item)
                <div class="wishlist-card">
                    <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}">
                    <div class="wishlist-info">
                        <h3 class="wishlist-name">{{ $item->product->name }}</h3>
                        <p class="wishlist-price">₹{{ number_format($item->product->price, 2) }}</p>
                    </div>
                    <div class="wishlist-actions">
                        <form action="{{ route('cart.add') }}" method="POST" style="flex:1;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn-add-cart" style="width:100%;">Add to Cart</button>
                        </form>
                        <form action="{{ route('wishlist.remove') }}" method="POST" style="flex:1;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <button type="submit" class="btn-remove" style="width:100%;">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-wishlist">
            <h2>Your wishlist is empty</h2>
            <p style="color:#888; margin:20px 0;">Save items you love for later.</p>
            <a href="{{ route('products.index') }}">Continue Shopping</a>
        </div>
    @endif
</div>
@endsection
