@extends('layouts.app')

@section('title', $product->name . ' — VOGUE')

@push('styles')
<style>
.product-detail { display:grid; grid-template-columns:1fr 1fr; gap:40px; padding:40px 0; }
.product-gallery img { width:100%; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
.product-info { display:flex; flex-direction:column; gap:20px; }
.product-title { font-size:2rem; font-weight:700; color:#222; margin:0; }
.product-price { font-size:1.8rem; font-weight:700; color:#000; }
.product-category { color:#888; font-size:1rem; text-transform:capitalize; }
.product-description { color:#555; line-height:1.8; }

.size-selector { display:flex; gap:10px; flex-wrap:wrap; }
.size-option { padding:10px 20px; border:2px solid #ddd; border-radius:8px; cursor:pointer; transition:0.3s; }
.size-option:hover, .size-option.active { border-color:#222; background:#222; color:#fff; }

.quantity-selector { display:flex; align-items:center; gap:15px; }
.qty-btn { width:40px; height:40px; border:1px solid #ddd; background:#fff; border-radius:8px; font-size:1.2rem; cursor:pointer; }
.qty-input { width:60px; text-align:center; padding:10px; border:1px solid #ddd; border-radius:8px; }

.action-buttons { display:flex; gap:15px; margin-top:20px; }
.btn-cart, .btn-wishlist {
    flex:1; padding:15px 30px; border:none; border-radius:8px;
    font-size:1rem; font-weight:600; cursor:pointer; transition:0.3s;
}
.btn-cart { background:#222; color:#fff; }
.btn-cart:hover { background:#444; }
.btn-wishlist { background:#fff; border:2px solid #222; color:#222; }
.btn-wishlist:hover { background:#f5f5f5; }

@media (max-width: 768px) {
    .product-detail { grid-template-columns:1fr; }
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="breadcrumbs">
        <a href="{{ route('home') }}">Home</a> / 
        <a href="{{ route('products.index') }}">Shop</a> / 
        {{ $product->name }}
    </div>

    <div class="product-detail">
        <div class="product-gallery">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
        </div>

        <div class="product-info">
            <span class="product-category">{{ ucwords(str_replace('-', ' ', $product->category)) }}</span>
            <h1 class="product-title">{{ $product->name }}</h1>
            <span class="product-price">₹{{ number_format($product->price, 2) }}</span>

            <p class="product-description">{{ $product->description }}</p>

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                @if($product->sizes)
                <div style="margin-bottom:20px;">
                    <label style="font-weight:600; margin-bottom:10px; display:block;">Select Size:</label>
                    <div class="size-selector">
                        @foreach(explode(',', $product->sizes) as $size)
                            <label class="size-option">
                                <input type="radio" name="size" value="{{ trim($size) }}" style="display:none;" required>
                                {{ trim($size) }}
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="quantity-selector">
                    <label style="font-weight:600;">Quantity:</label>
                    <button type="button" class="qty-btn" onclick="changeQty(-1)">-</button>
                    <input type="number" name="quantity" value="1" min="1" class="qty-input" id="qtyInput">
                    <button type="button" class="qty-btn" onclick="changeQty(1)">+</button>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn-cart">Add to Cart</button>
                    <button type="button" class="btn-wishlist" onclick="addToWishlist({{ $product->id }})">
                        ♡ Wishlist
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function changeQty(delta) {
    const input = document.getElementById('qtyInput');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
}

document.querySelectorAll('.size-option').forEach(opt => {
    opt.addEventListener('click', function() {
        document.querySelectorAll('.size-option').forEach(o => o.classList.remove('active'));
        this.classList.add('active');
        this.querySelector('input').checked = true;
    });
});

function addToWishlist(productId) {
    fetch('{{ route("wishlist.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => res.json())
    .then(data => alert(data.message))
    .catch(err => alert('Please login to add to wishlist'));
}
</script>
@endpush
