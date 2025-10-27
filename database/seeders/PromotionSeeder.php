<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        // โปรโค้ดลดทุกสินค้า 15%
        $chamora = Promotion::create([
            'code' => 'chamora',
            'name' => 'Chamora 15% Off All Products',
            'discount_percent' => 15,
            'applies_to' => 'all',
            'is_active' => true,
        ]);

        // โปรลดเฉพาะ Hirono และ Kuromi
        $collection10 = Promotion::create([
            'code' => 'collection10',
            'name' => 'Hirono & Kuromi 10% Off',
            'discount_percent' => 10,
            'applies_to' => 'collection',
            'is_active' => true,
        ]);

        // collecotion10 ใช้กับ Category Hirono และ Kuromi
        DB::table('promotion_collections')->insert([
            ['promotion_id' => $collection10->id, 'category_id' => 3], // Kuromi
            ['promotion_id' => $collection10->id, 'category_id' => 4], // Hirono
        ]);
    }
}
