<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sizes' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $imagePath,
            'sizes' => $request->sizes,
            'stock' => $request->stock ?? 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sizes' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = 'uploads/products/' . $filename;
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $imagePath,
            'sizes' => $request->sizes,
            'stock' => $request->stock ?? 0,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
