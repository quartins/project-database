<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // สร้างข้อมูล Product ทั้งหมด
        Product::create(['name' => 'Hello Kitty Figurine 1', 'price' => 480.0, 'image_url' => 'collection/kitty/kitty2.png', 'category_id' => 1]);
        Product::create(['name' => 'Hello Kitty Figurine 2', 'price' => 430.0, 'image_url' => 'collection/kitty/kitty3.png', 'category_id' => 1]);
        
        Product::create(['name' => 'My Melody Plush 1', 'price' => 490.0, 'image_url' => 'collection/mymelody/mymelody2.png', 'category_id' => 2]);
        Product::create(['name' => 'My Melody Plush 2', 'price' => 490.0, 'image_url' => 'collection/mymelody/mymelody3.png', 'category_id' => 2]);

        Product::create(['name' => 'Kuromi Figure 1', 'price' => 480.0, 'image_url' => 'collection/kuromi/kuromi2.png', 'category_id' => 3]);
        Product::create(['name' => 'Kuromi Figure 2', 'price' => 480.0, 'image_url' => 'collection/kuromi/kuromi3.png', 'category_id' => 3]);
        
        Product::create(['name' => 'Hirono Figure 1', 'price' => 480.0, 'image_url' => 'collection/hirono/hirono2.png', 'category_id' => 4]);
        Product::create(['name' => 'Hirono Figure 2', 'price' => 480.0, 'image_url' => 'collection/hirono/hirono3.png', 'category_id' => 4]);

        Product::create(['name' => 'Twinkle Figurine 1', 'price' => 480.0, 'image_url' => 'collection/twinkle/twinkle2.png', 'category_id' => 5]);
        Product::create(['name' => 'Twinkle Figurine 2', 'price' => 480.0, 'image_url' => 'collection/twinkle/twinkle3.png', 'category_id' => 5]);
    }
}