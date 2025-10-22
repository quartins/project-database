<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

  // รายละเอียดสินค้า: รองรับ /products/{id} และ /products/{id}-{slug}
    // มี canonical redirect + รองรับ qty และ return url
    public function show(Request $request, string $key)
    {
        // ดึงเฉพาะเลข id ก่อนเครื่องหมาย '-'
        $id = (int) strtok($key, '-');

        // โหลดความสัมพันธ์ที่ต้องใช้ใน view
        $product = Product::with(['category','materials'])->findOrFail($id);

        // คำนวณ slug จากชื่อ (ไม่มีคอลัมน์ slug ก็สร้างจากชื่อได้)
        $slug = Str::slug($product->name);
        $want = $product->id . '-' . $slug;

        // ถ้า key ไม่ตรงรูปแบบ canonical -> redirect 301 ให้เป็น URL เดียว
        if ($key !== $want) {
            return redirect()->route('products.show', ['key' => $want], 301);
        }

        // ค่าพารามิเตอร์เสริมสำหรับฟอร์มจำนวน/ย้อนกลับ (ถ้าจะใช้)
        $qty = max(1, (int) $request->query('qty', 1));
        $return = $request->query('return', url()->previous());

        return view('products.show', compact('product','slug','qty','return'));
    }
}
