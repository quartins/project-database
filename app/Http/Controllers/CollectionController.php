<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    // Method สำหรับหน้า /collections
    public function index()
{
    $categories = \App\Models\Category::with([
        'products' => fn ($q) => $q->select('id','category_id','image_url')->limit(1)
    ])->get();

    return view('collections.index', compact('categories'));
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