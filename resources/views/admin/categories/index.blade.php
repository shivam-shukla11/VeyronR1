@extends('layouts.admin')

@section('title', 'Categories — Admin')

@push('styles')
<style>
.categories-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
.category-card { background: #fff; border-radius: 12px; padding: 25px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
.category-name { font-weight: 600; color: #222; text-transform: capitalize; }
</style>
@endpush

@section('content')
<h2 style="margin-bottom: 25px;">Categories</h2>

<div class="categories-grid">
    @forelse($categories as $category)
        <div class="category-card">
            <span class="material-icons" style="font-size:2rem; color:#888; margin-bottom:10px;">category</span>
            <div class="category-name">{{ ucwords(str_replace('-', ' ', $category->name)) }}</div>
        </div>
    @empty
        <p style="color:#888;">No categories found.</p>
    @endforelse
</div>
@endsection
