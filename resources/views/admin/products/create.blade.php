@extends('layouts.admin')

@section('title', 'Add Product — Admin')

@push('styles')
<style>
.form-card { background: #fff; border-radius: 12px; padding: 30px; max-width: 700px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
.form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 1rem; }
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #222; outline: none; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.btn-submit { background: #222; color: #fff; padding: 14px 30px; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; }
.btn-submit:hover { background: #444; }
.btn-cancel { background: #f5f5f5; color: #333; padding: 14px 30px; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer; margin-left: 10px; text-decoration: none; }
</style>
@endpush

@section('content')
<h2 style="margin-bottom: 25px;">Add New Product</h2>

<div class="form-card">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label>Product Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Price (₹) *</label>
                <input type="number" name="price" step="0.01" value="{{ old('price') }}" required>
            </div>
            <div class="form-group">
                <label>Stock Quantity</label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}">
            </div>
        </div>

        <div class="form-group">
            <label>Category *</label>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="men-shirt">Men - Shirts</option>
                <option value="men-jeans">Men - Jeans</option>
                <option value="men-jacket">Men - Jackets</option>
                <option value="men-sweatshirt">Men - Sweatshirts</option>
                <option value="women-tops">Women - Tops</option>
                <option value="women-bottoms">Women - Bottoms</option>
                <option value="women-skirts">Women - Skirts</option>
                <option value="women-sweatshirt">Women - Sweatshirts</option>
            </select>
        </div>

        <div class="form-group">
            <label>Sizes (comma-separated, e.g., S,M,L,XL)</label>
            <input type="text" name="sizes" value="{{ old('sizes') }}" placeholder="S,M,L,XL">
        </div>

        <div class="form-group">
            <label>Product Image *</label>
            <input type="file" name="image" accept="image/*" required>
        </div>

        <div style="margin-top: 30px;">
            <button type="submit" class="btn-submit">Add Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>
@endsection
