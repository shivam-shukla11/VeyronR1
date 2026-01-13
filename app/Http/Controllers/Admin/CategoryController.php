<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('admin_products')
            ->select('category as name')
            ->distinct()
            ->orderBy('category')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }
}
