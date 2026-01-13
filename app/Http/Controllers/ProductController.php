<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Gender filter
        if ($request->filled('gender')) {
            if ($request->gender === 'men') {
                $query->where('category', 'like', 'men-%');
            } elseif ($request->gender === 'women') {
                $query->where('category', 'like', 'women-%');
            }
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Price filters
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->orderBy('id', 'desc')->get();

        // Get distinct categories
        $categories = DB::table('admin_products')
            ->select('category as name')
            ->distinct()
            ->orderBy('category')
            ->get();

        return view('shop.products', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('shop.product-detail', compact('product'));
    }
}
