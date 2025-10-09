<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
 public function index()
{
    // ดึงสินค้าทั้งหมด 
    $products = Product::all();

    //  ดึงเฉพาะรูปที่ 2 และ 3 ของแต่ละ collection
    $recommended = collect();

    for ($i = 1; $i <= 5; $i++) {
        $subset = Product::where('category_id', $i)
                    ->skip(1)   // ข้ามรูปที่ 1
                    ->take(2)   // เอาแค่ 2 รูป (รูปที่ 2 และ 3)
                    ->get();

        $recommended = $recommended->merge($subset);
    }

    return view('homepage.home', compact('products', 'recommended'));
}
}
