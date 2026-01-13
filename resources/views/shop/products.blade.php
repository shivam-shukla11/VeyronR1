@extends('layouts.app')

@section('title', 'VOGUE — Shop')

@push('styles')
<style>
body { font-family:'Poppins', sans-serif; margin:0; padding:0; background:#f4f4f4; color:#333; }

.container { max-width:1200px; margin:2rem auto; padding:0 1rem; }
.layout { display:flex; gap:20px; }

/* Cart icon badge */
.nav .cart-link { position: relative; display: inline-flex; align-items: center; }
.nav .cart-badge {
    position: absolute; top: -6px; right: -6px;
    min-width: 18px; height: 18px; padding: 0 5px;
    border-radius: 999px; background:#000; color:#fff;
    font-size:11px; line-height:18px; text-align:center; font-weight:700;
}

/* Search Filter Bar */
.search-filter-bar { display:flex; align-items:center; gap:12px; flex:2; justify-content:flex-end; flex-wrap:wrap; }
.search-form { flex:1; }
.search-input-wrap {
    display:flex; align-items:center; width:100%; background:#fff;
    border:1px solid #d4d5d9; border-radius:8px; overflow:hidden;
}
.search-input-wrap input[type="search"] {
    flex:1; padding:11px 12px; border:0; outline:0; font-size:1rem; color:#333;
}
.search-input-wrap button {
    display:flex; align-items:center; justify-content:center;
    width:44px; height:34px; border:0; background:#f5f5f6; color:#535766; cursor:pointer;
}
.search-input-wrap button:hover { background:#ececec; }

/* Sidebar */
.sidebar {
    width:250px; background:#fff; border-radius:12px; padding:20px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08); height:fit-content; position:sticky; top:80px;
}
.sidebar h3 { margin:0 0 15px; font-size:1.1rem; color:#222; border-bottom:2px solid #eee; padding-bottom:10px; }
.filter { margin-bottom:20px; }
.filter label { font-weight:500; display:block; margin-bottom:8px; color:#444; }
.filter select, .filter input { width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; font-size:0.95rem; }
.filter-btn {
    width:100%; padding:12px; background:#222; color:#fff; border:none;
    border-radius:8px; font-weight:500; cursor:pointer; transition:0.3s;
}
.filter-btn:hover { background:#444; }

/* Products Grid */
.products-grid {
    flex:1; display:grid;
    grid-template-columns:repeat(auto-fill, minmax(240px, 1fr));
    gap:20px;
}

.product-card {
    background:#fff; border-radius:12px; overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,0.08); transition:transform 0.3s, box-shadow 0.3s;
    display:flex; flex-direction:column;
}
.product-card:hover { transform:translateY(-5px); box-shadow:0 8px 20px rgba(0,0,0,0.12); }

.product-image { position:relative; overflow:hidden; }
.product-image img { width:100%; height:280px; object-fit:cover; transition:transform 0.3s; }
.product-card:hover .product-image img { transform:scale(1.05); }

.product-info { padding:15px; display:flex; flex-direction:column; gap:8px; }
.product-name { font-weight:600; font-size:1rem; color:#222; margin:0; }
.product-price { font-size:1.1rem; font-weight:700; color:#000; }
.product-category { font-size:0.85rem; color:#888; text-transform:capitalize; }

.view-btn {
    display:block; text-align:center; padding:12px;
    background:#f5f5f5; color:#333; text-decoration:none;
    font-weight:500; transition:0.3s; border-top:1px solid #eee;
}
.view-btn:hover { background:#222; color:#fff; }

.no-products { text-align:center; padding:50px; color:#888; font-size:1.1rem; grid-column:1/-1; }

@media (max-width: 768px) {
    .layout { flex-direction:column; }
    .sidebar { width:100%; position:static; }
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="layout">
        <!-- Sidebar Filters -->
        <aside class="sidebar">
            <h3>Filter Products</h3>
            <form method="GET" action="{{ route('products.index') }}">
                <div class="filter">
                    <label>Search</label>
                    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
                </div>
                
                <div class="filter">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="">All</option>
                        <option value="men" {{ request('gender') == 'men' ? 'selected' : '' }}>Men</option>
                        <option value="women" {{ request('gender') == 'women' ? 'selected' : '' }}>Women</option>
                    </select>
                </div>

                <div class="filter">
                    <label>Category</label>
                    <select name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                                {{ ucwords(str_replace('-', ' ', $cat->name)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter">
                    <label>Min Price (₹)</label>
                    <input type="number" name="min_price" placeholder="0" value="{{ request('min_price') }}">
                </div>

                <div class="filter">
                    <label>Max Price (₹)</label>
                    <input type="number" name="max_price" placeholder="10000" value="{{ request('max_price') }}">
                </div>

                <button type="submit" class="filter-btn">Apply Filters</button>
            </form>
        </aside>

        <!-- Products Grid -->
        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <span class="product-category">{{ ucwords(str_replace('-', ' ', $product->category)) }}</span>
                        <span class="product-price">₹{{ number_format($product->price, 2) }}</span>
                    </div>
                    <a href="{{ route('products.show', $product->id) }}" class="view-btn">View Details</a>
                </div>
            @empty
                <div class="no-products">
                    <p>No products found matching your criteria.</p>
                    <a href="{{ route('products.index') }}" style="color:#222; text-decoration:underline;">Clear filters</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
