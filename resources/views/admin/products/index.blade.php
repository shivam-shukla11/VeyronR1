@extends('layouts.admin')

@section('title', 'Products — Admin')

@push('styles')
<style>
.page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.btn-add { background: #10b981; color: #fff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; }
.btn-add:hover { background: #059669; }

.products-table { width: 100%; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.products-table th, .products-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
.products-table th { background: #f9fafb; font-weight: 600; color: #666; }
.products-table img { width: 60px; height: 80px; object-fit: cover; border-radius: 6px; }

.action-btn { padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; margin-right: 5px; }
.btn-edit { background: #dbeafe; color: #1e40af; }
.btn-delete { background: #fee2e2; color: #991b1b; border: none; cursor: pointer; }
</style>
@endpush

@section('content')
<div class="page-header">
    <h2>Products</h2>
    <a href="{{ route('admin.products.create') }}" class="btn-add">+ Add Product</a>
</div>

<table class="products-table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr>
                <td><img src="{{ asset($product->image) }}" alt="{{ $product->name }}"></td>
                <td>{{ $product->name }}</td>
                <td>{{ ucwords(str_replace('-', ' ', $product->category)) }}</td>
                <td>₹{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="action-btn btn-edit">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center; padding:30px; color:#888;">No products found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
