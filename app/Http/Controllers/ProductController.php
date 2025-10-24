<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // หน้า Home
    public function index()
    {
        // สินค้าทั้งหมด (ไม่จำเป็นต้อง eager load อะไรใน home)
        $products = Product::all();

        // แนะนำ: ดึงรูปที่ 2–3 ของแต่ละ category id 1..5
        $recommended = collect();
        for ($i = 1; $i <= 5; $i++) {
            $subset = Product::where('category_id', $i)
                ->skip(1)->take(2)->get();
            $recommended = $recommended->merge($subset);
        }

        return view('homepage.home', compact('products', 'recommended'));
    }

    // /products/{id} หรือ /products/{id}-{slug}
    public function show(Request $request, string $key)
    {
        // ตัดเอาเฉพาะ id ก่อนขีด
        $id = (int) Str::before($key, '-');

        // โหลดความสัมพันธ์ที่ต้องใช้ใน view (materials สำหรับ Composition)
        $product = Product::with(['category', 'materials'])->findOrFail($id);

        // ใช้ slug จาก DB เป็นหลัก; ถ้าไม่มี คำนวณจาก name ชั่วคราว
        $slugDb = trim((string)($product->slug ?? ''));
        $slug   = $slugDb !== '' ? $slugDb : Str::slug($product->name);
        $want   = $product->id . '-' . $slug;

        // บังคับ canonical URL
        if ($key !== $want) {
            return redirect()->route('products.show', ['key' => $want], 301);
        }

        // จำนวนขั้นต่ำ 1 และไม่เกินสต็อก (ถ้ามีระบุสต็อก)
        $stock = (int) ($product->stock_qty ?? 0);
        $qty   = max(1, (int) $request->query('qty', 1));
        if ($stock > 0) {
            $qty = min($qty, $stock);
        }

        // หน้าก่อนหน้า (ใช้ในปุ่ม back/return)
        $return = $request->query('return', url()->previous());

        return view('products.show', compact('product', 'slug', 'qty', 'return'));
    }

    // ค้นหา (autocomplete / live search)
    public function search(Request $request)
    {
        $q = (string) $request->get('q', '');
        $products = Product::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($q) . '%'])->get();

        // แปลง image_url ให้เป็น URL เต็มสำหรับ frontend
        $products->transform(function ($p) {
            $p->image_url = asset($p->image_url);
            return $p;
        });

        return response()->json($products);
    }
}
