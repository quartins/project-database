<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    // Method สำหรับหน้า /collections
    public function index()
    {
        $categories = Category::all();
        return view('collections.index', ['categories' => $categories]);
    }

    // Method สำหรับหน้า /collections/{id}
    public function show(Category $category)
    {
        $products = $category->products()->get();
        return view('collections.show', [
            'category' => $category,
            'products' => $products
        ]);
    }
}