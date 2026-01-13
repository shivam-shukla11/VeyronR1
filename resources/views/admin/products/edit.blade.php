@extends('layouts.admin')

@section('title', 'Edit Product — Admin')

@push('styles')
<style>
.form-card { background: #fff; border-radius: 12px; padding: 30px; max-width: 700px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
.form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.btn-submit { background: #222; color: #fff; padding: 14px 30px; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; }
.btn-cancel { background: #f5f5f5; color: #333; padding: 14px 30px; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer; margin-left: 10px; text-decoration: none; }
.current-image { margin-top: 10px; }
.current-image img { width: 100px; height: 130px; object-fit: cover; border-radius: 8px; }
</style>
@endpush

@section('content')
<h2 style="margin-bottom: 25px;">Edit Product</h2>

<div class="form-card">
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Product Name *</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Price (₹) *</label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
            </div>
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Category *</label>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="men-shirt" {{ $product->category == 'men-shirt' ? 'selected' : '' }}>Men - Shirts</option>
                <option value="men-jeans" {{ $product->category == 'men-jeans' ? 'selected' : '' }}>Men - Jeans</option>
                <option value="men-jacket" {{ $product->category == 'men-jacket' ? 'selected' : '' }}>Men - Jackets</option>
                <option value="men-sweatshirt" {{ $product->category == 'men-sweatshirt' ? 'selected' : '' }}>Men - Sweatshirts</option>
                <option value="women-tops" {{ $product->category == 'women-tops' ? 'selected' : '' }}>Women - Tops</option>
                <option value="women-bottoms" {{ $product->category == 'women-bottoms' ? 'selected' : '' }}>Women - Bottoms</option>
                <option value="women-skirts" {{ $product->category == 'women-skirts' ? 'selected' : '' }}>Women - Skirts</option>
                <option value="women-sweatshirt" {{ $product->category == 'women-sweatshirt' ? 'selected' : '' }}>Women - Sweatshirts</option>
            </select>
        </div>

        <div class="form-group">
            <label>Sizes (comma-separated)</label>
            <input type="text" name="sizes" value="{{ old('sizes', $product->sizes) }}" placeholder="S,M,L,XL">
        </div>

        <div class="form-group">
            <label>Product Image (leave empty to keep current)</label>
            <input type="file" name="image" accept="image/*">
            @if($product->image)
                <div class="current-image">
                    <p style="margin:10px 0 5px; color:#666;">Current image:</p>
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                </div>
            @endif
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn-submit">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
