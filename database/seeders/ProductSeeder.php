<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // helper: คืนค่า id ของหมวดตามชื่อ (สร้างให้ถ้ายังไม่มี)
        $catId = function (string $name): ?int {
            $cat = Category::firstOrCreate(['name' => $name]);
            return $cat->id ?? null;
        };

        // ใช้ 'category' เป็นชื่อหมวดแทนการล็อกเลข id
        $items = [
            // 🩷 Kitty Collection
            ['name'=>'Hello Kitty Figurine', 'price'=>480, 'stock_qty'=>10, 'image_url'=>'collection/kitty/kitty2.png',  'category'=>'Kitty Collection'],
            ['name'=>'Hello Kitty Figurine', 'price'=>430, 'stock_qty'=>8,  'image_url'=>'collection/kitty/kitty3.png',  'category'=>'Kitty Collection'],
            ['name'=>'Hello Kitty Figurine', 'price'=>430, 'stock_qty'=>8,  'image_url'=>'collection/kitty/kitty4.png',  'category'=>'Kitty Collection'],
            ['name'=>'Hello Kitty Figurine', 'price'=>430, 'stock_qty'=>8,  'image_url'=>'collection/kitty/kitty5.png',  'category'=>'Kitty Collection'],
            ['name'=>'Hello Kitty Figurine', 'price'=>430, 'stock_qty'=>8,  'image_url'=>'collection/kitty/kitty6.png',  'category'=>'Kitty Collection'],
            ['name'=>'Hello Kitty Figurine', 'price'=>430, 'stock_qty'=>8,  'image_url'=>'collection/kitty/kitty7.png',  'category'=>'Kitty Collection'],
            ['name'=>'Hello Kitty Figurine', 'price'=>430, 'stock_qty'=>8,  'image_url'=>'collection/kitty/kitty8.png',  'category'=>'Kitty Collection'],
            ['name'=>'Hello Kitty Figurine', 'price'=>430, 'stock_qty'=>8,  'image_url'=>'collection/kitty/kitty9.png',  'category'=>'Kitty Collection'],
            ['name'=>'Hello Kitty Figurine', 'price'=>430, 'stock_qty'=>8,  'image_url'=>'collection/kitty/kitty10.png', 'category'=>'Kitty Collection'],

            // 💖 My Melody Collection
            ['name'=>'My Melody Plush', 'price'=>490, 'stock_qty'=>12, 'image_url'=>'collection/mymelody/mymelody2.png',  'category'=>'My Melody Collection'],
            ['name'=>'My Melody Plush', 'price'=>490, 'stock_qty'=>9,  'image_url'=>'collection/mymelody/mymelody3.png',  'category'=>'My Melody Collection'],
            ['name'=>'My Melody Plush', 'price'=>490, 'stock_qty'=>9,  'image_url'=>'collection/mymelody/mymelody4.png',  'category'=>'My Melody Collection'],
            ['name'=>'My Melody Plush', 'price'=>490, 'stock_qty'=>9,  'image_url'=>'collection/mymelody/mymelody5.png',  'category'=>'My Melody Collection'],
            ['name'=>'My Melody Plush', 'price'=>490, 'stock_qty'=>9,  'image_url'=>'collection/mymelody/mymelody6.png',  'category'=>'My Melody Collection'],
            ['name'=>'My Melody Plush', 'price'=>490, 'stock_qty'=>9,  'image_url'=>'collection/mymelody/mymelody7.png',  'category'=>'My Melody Collection'],
            ['name'=>'My Melody Plush', 'price'=>490, 'stock_qty'=>9,  'image_url'=>'collection/mymelody/mymelody8.png',  'category'=>'My Melody Collection'],
            ['name'=>'My Melody Plush', 'price'=>490, 'stock_qty'=>9,  'image_url'=>'collection/mymelody/mymelody9.png',  'category'=>'My Melody Collection'],
            ['name'=>'My Melody Plush', 'price'=>490, 'stock_qty'=>9,  'image_url'=>'collection/mymelody/mymelody10.png', 'category'=>'My Melody Collection'],

            // 🖤 Kuromi Collection
            ['name'=>'Kuromi Figure 2', 'price'=>480, 'stock_qty'=>11, 'image_url'=>'collection/kuromi/kuromi2.png',  'category'=>'Kuromi Collection'],
            ['name'=>'Kuromi Figure 3', 'price'=>480, 'stock_qty'=>7,  'image_url'=>'collection/kuromi/kuromi3.png',  'category'=>'Kuromi Collection'],
            ['name'=>'Kuromi Figure 3', 'price'=>480, 'stock_qty'=>7,  'image_url'=>'collection/kuromi/kuromi4.png',  'category'=>'Kuromi Collection'],
            ['name'=>'Kuromi Figure 3', 'price'=>480, 'stock_qty'=>7,  'image_url'=>'collection/kuromi/kuromi5.png',  'category'=>'Kuromi Collection'],
            ['name'=>'Kuromi Figure 3', 'price'=>480, 'stock_qty'=>7,  'image_url'=>'collection/kuromi/kuromi6.png',  'category'=>'Kuromi Collection'],
            ['name'=>'Kuromi Figure 3', 'price'=>480, 'stock_qty'=>7,  'image_url'=>'collection/kuromi/kuromi7.png',  'category'=>'Kuromi Collection'],
            ['name'=>'Kuromi Figure 3', 'price'=>480, 'stock_qty'=>7,  'image_url'=>'collection/kuromi/kuromi8.png',  'category'=>'Kuromi Collection'],
            ['name'=>'Kuromi Figure 3', 'price'=>480, 'stock_qty'=>7,  'image_url'=>'collection/kuromi/kuromi9.png',  'category'=>'Kuromi Collection'],
            ['name'=>'Kuromi Figure 3', 'price'=>480, 'stock_qty'=>7,  'image_url'=>'collection/kuromi/kuromi10.png', 'category'=>'Kuromi Collection'],

            // 🩵 Hirono Collection
            ['name'=>'Hirono Figure 2', 'price'=>480, 'stock_qty'=>10, 'image_url'=>'collection/hirono/hirono2.png',  'category'=>'Hirono Collection'],
            ['name'=>'Hirono Figure 3', 'price'=>480, 'stock_qty'=>8,  'image_url'=>'collection/hirono/hirono3.png',  'category'=>'Hirono Collection'],
            ['name'=>'Hirono Figure 3', 'price'=>480, 'stock_qty'=>8,  'image_url'=>'collection/hirono/hirono4.png',  'category'=>'Hirono Collection'],
            ['name'=>'Hirono Figure 3', 'price'=>480, 'stock_qty'=>8,  'image_url'=>'collection/hirono/hirono5.png',  'category'=>'Hirono Collection'],
            ['name'=>'Hirono Figure 3', 'price'=>480, 'stock_qty'=>8,  'image_url'=>'collection/hirono/hirono6.png',  'category'=>'Hirono Collection'],
            ['name'=>'Hirono Figure 3', 'price'=>480, 'stock_qty'=>8,  'image_url'=>'collection/hirono/hirono7.png',  'category'=>'Hirono Collection'],
            ['name'=>'Hirono Figure 3', 'price'=>480, 'stock_qty'=>8,  'image_url'=>'collection/hirono/hirono8.png',  'category'=>'Hirono Collection'],
            ['name'=>'Hirono Figure 3', 'price'=>480, 'stock_qty'=>8,  'image_url'=>'collection/hirono/hirono9.png',  'category'=>'Hirono Collection'],
            ['name'=>'Hirono Figure 3', 'price'=>480, 'stock_qty'=>8,  'image_url'=>'collection/hirono/hirono10.png', 'category'=>'Hirono Collection'],

            // 🌟 Twinkle Collection
            ['name'=>'Twinkle Figurine 2', 'price'=>480, 'stock_qty'=>10, 'image_url'=>'collection/twinkle/twinkle2.png',  'category'=>'Twinkle Collection'],
            ['name'=>'Twinkle Figurine 3', 'price'=>480, 'stock_qty'=>6,  'image_url'=>'collection/twinkle/twinkle3.png',  'category'=>'Twinkle Collection'],
            ['name'=>'Twinkle Figurine 3', 'price'=>480, 'stock_qty'=>6,  'image_url'=>'collection/twinkle/twinkle4.png',  'category'=>'Twinkle Collection'],
            ['name'=>'Twinkle Figurine 3', 'price'=>480, 'stock_qty'=>6,  'image_url'=>'collection/twinkle/twinkle5.png',  'category'=>'Twinkle Collection'],
            ['name'=>'Twinkle Figurine 3', 'price'=>480, 'stock_qty'=>6,  'image_url'=>'collection/twinkle/twinkle6.png',  'category'=>'Twinkle Collection'],
            ['name'=>'Twinkle Figurine 3', 'price'=>480, 'stock_qty'=>6,  'image_url'=>'collection/twinkle/twinkle7.png',  'category'=>'Twinkle Collection'],
            ['name'=>'Twinkle Figurine 3', 'price'=>480, 'stock_qty'=>6,  'image_url'=>'collection/twinkle/twinkle8.png',  'category'=>'Twinkle Collection'],
            ['name'=>'Twinkle Figurine 3', 'price'=>480, 'stock_qty'=>6,  'image_url'=>'collection/twinkle/twinkle9.png',  'category'=>'Twinkle Collection'],
            ['name'=>'Twinkle Figurine 3', 'price'=>480, 'stock_qty'=>6,  'image_url'=>'collection/twinkle/twinkle10.png', 'category'=>'Twinkle Collection'],
        ];

        foreach ($items as $it) {
            $cid = $catId($it['category']);
            if (!$cid) continue;

            // ใช้กุญแจผสม แยกสินค้าที่ชื่อเหมือนกันแต่รูป/หมวดต่างกัน
            Product::updateOrCreate(
                [
                    'name'        => $it['name'],
                    'image_url'   => $it['image_url'],
                    'category_id' => $cid,
                ],
                [
                    'price'      => $it['price'],
                    'stock_qty'  => $it['stock_qty'],
                ]
            );
        }
    }
}
