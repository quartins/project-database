<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        //  ลดทุกสินค้า 15%
        $chamora = Promotion::create([
            'code' => 'chamora',
            'name' => 'Chamora 15% Off All Products',
            'discount_percent' => 15,
            'applies_to' => 'all',
            'is_active' => true,
        ]);

        //  Kuromi Only
        $kurolove = Promotion::create([
            'code' => 'kurolove',
            'name' => 'Kuromi Collection 10% Off',
            'discount_percent' => 10,
            'applies_to' => 'collection',
            'is_active' => true,
        ]);

        //  Hirono Only
        $prince10 = Promotion::create([
            'code' => 'prince10',
            'name' => 'Hirono Collection 10% Off',
            'discount_percent' => 10,
            'applies_to' => 'collection',
            'is_active' => true,
        ]);

        //  Kuromi + Hirono
        $friendship10 = Promotion::create([
            'code' => 'friendship10',
            'name' => 'Friendship Combo 10% Off (Kuromi + Hirono)',
            'discount_percent' => 10,
            'applies_to' => 'combo',
            'is_active' => true,
        ]);

        // Map collection → promotion
        DB::table('promotion_collections')->insert([
            ['promotion_id' => $kurolove->id, 'category_id' => 3], // Kuromi
            ['promotion_id' => $prince10->id, 'category_id' => 4], // Hirono
            ['promotion_id' => $friendship10->id, 'category_id' => 3], // Kuromi (part of combo)
            ['promotion_id' => $friendship10->id, 'category_id' => 4], // Hirono (part of combo)
        ]);
    }
}
