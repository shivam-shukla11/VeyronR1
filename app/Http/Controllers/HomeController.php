<?php

namespace App\Http\Controllers;

use App\Models\MediaFile;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $media = MediaFile::orderBy('created_at', 'desc')->get();
        
        $posters = [
            ["file" => "menjacket.jpg", "line1" => "Define your winter style", "line2" => "Luxury jackets for every look", "link" => route('products.index', ['category' => 'men-jacket'])],
            ["file" => "menshirt.jpg", "line1" => "Effortless elegance daily", "line2" => "Shirts that speak sophistication", "link" => route('products.index', ['category' => 'men-shirt'])],
            ["file" => "mensweatshirt.jpg", "line1" => "Comfort meets couture", "line2" => "Sweatshirts designed to impress", "link" => route('products.index', ['category' => 'men-sweatshirt'])],
            ["file" => "menjean.jpg", "line1" => "Iconic denim, timeless fit", "line2" => "Jeans that move with confidence", "link" => route('products.index', ['category' => 'men-jeans'])],
            ["file" => "womenskirt.jpg", "line1" => "Grace in every step", "line2" => "Skirts crafted for modern elegance", "link" => route('products.index', ['category' => 'women-skirts'])],
            ["file" => "womentop.jpg", "line1" => "Minimalism with impact", "line2" => "Tops that elevate your look", "link" => route('products.index', ['category' => 'women-tops'])],
            ["file" => "womensweatshirt.jpg", "line1" => "Chic comfort redefined", "line2" => "Women's sweatshirts with style", "link" => route('products.index', ['category' => 'women-sweatshirt'])],
            ["file" => "womenjeans.jpg", "line1" => "Sculpted for perfection", "line2" => "Women's jeans for every occasion", "link" => route('products.index', ['category' => 'women-bottoms'])],
        ];

        return view('shop.home', compact('media', 'posters'));
    }
}
