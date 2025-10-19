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
        Product::create(['name' => 'Hello Kitty Figurine 3', 'price' => 430.0, 'image_url' => 'collection/kitty/kitty4.png', 'category_id' => 1]);
        Product::create(['name' => 'Hello Kitty Figurine 4', 'price' => 430.0, 'image_url' => 'collection/kitty/kitty5.png', 'category_id' => 1]);
        Product::create(['name' => 'Hello Kitty Figurine 5', 'price' => 430.0, 'image_url' => 'collection/kitty/kitty6.png', 'category_id' => 1]);
        Product::create(['name' => 'Hello Kitty Figurine 6', 'price' => 430.0, 'image_url' => 'collection/kitty/kitty7.png', 'category_id' => 1]);
        Product::create(['name' => 'Hello Kitty Figurine 7', 'price' => 430.0, 'image_url' => 'collection/kitty/kitty8.png', 'category_id' => 1]);
        Product::create(['name' => 'Hello Kitty Figurine 8', 'price' => 430.0, 'image_url' => 'collection/kitty/kitty9.png', 'category_id' => 1]);
        Product::create(['name' => 'Hello Kitty Figurine 9', 'price' => 430.0, 'image_url' => 'collection/kitty/kitty10.png', 'category_id' => 1]);

        Product::create(['name' => 'My Melody Plush 1', 'price' => 490.0, 'image_url' => 'collection/mymelody/mymelody2.png', 'category_id' => 2]);
        Product::create(['name' => 'My Melody Plush 2', 'price' => 490.0, 'image_url' => 'collection/mymelody/mymelody3.png', 'category_id' => 2]);
        Product::create(['name' => 'My Melody Plush 3', 'price' => 490.0, 'image_url' => 'collection/mymelody/mymelody4.png', 'category_id' => 2]);
        Product::create(['name' => 'My Melody Plush 4', 'price' => 490.0, 'image_url' => 'collection/mymelody/mymelody5.png', 'category_id' => 2]);
        Product::create(['name' => 'My Melody Plush 5', 'price' => 490.0, 'image_url' => 'collection/mymelody/mymelody6.png', 'category_id' => 2]);
        Product::create(['name' => 'My Melody Plush 6', 'price' => 490.0, 'image_url' => 'collection/mymelody/mymelody7.png', 'category_id' => 2]);
        Product::create(['name' => 'My Melody Plush 7', 'price' => 490.0, 'image_url' => 'collection/mymelody/mymelody8.png', 'category_id' => 2]);
        Product::create(['name' => 'My Melody Plush 8', 'price' => 490.0, 'image_url' => 'collection/mymelody/mymelody9.png', 'category_id' => 2]);
        Product::create(['name' => 'My Melody Plush 9', 'price' => 490.0, 'image_url' => 'collection/mymelody/mymelody10.png', 'category_id' => 2]);

        Product::create(['name' => 'Kuromi Figure 1', 'price' => 480.0, 'image_url' => 'collection/kuromi/kuromi2.png', 'category_id' => 3]);
        Product::create(['name' => 'Kuromi Figure 2', 'price' => 480.0, 'image_url' => 'collection/kuromi/kuromi3.png', 'category_id' => 3]);
        Product::create(['name' => 'Kuromi Figure 3', 'price' => 480.0, 'image_url' => 'collection/kuromi/kuromi4.png', 'category_id' => 3]);
        Product::create(['name' => 'Kuromi Figure 4', 'price' => 480.0, 'image_url' => 'collection/kuromi/kuromi5.png', 'category_id' => 3]);
        Product::create(['name' => 'Kuromi Figure 5', 'price' => 480.0, 'image_url' => 'collection/kuromi/kuromi6.png', 'category_id' => 3]);
        Product::create(['name' => 'Kuromi Figure 6', 'price' => 480.0, 'image_url' => 'collection/kuromi/kuromi7.png', 'category_id' => 3]);
        Product::create(['name' => 'Kuromi Figure 7', 'price' => 480.0, 'image_url' => 'collection/kuromi/kuromi8.png', 'category_id' => 3]);
        Product::create(['name' => 'Kuromi Figure 8', 'price' => 480.0, 'image_url' => 'collection/kuromi/kuromi9.png', 'category_id' => 3]);
        Product::create(['name' => 'Kuromi Figure 9', 'price' => 480.0, 'image_url' => 'collection/kuromi/kuromi10.png', 'category_id' => 3]);
       
        Product::create(['name' => 'Hirono Figure 1', 'price' => 480.0, 'image_url' => 'collection/hirono/hirono2.png', 'category_id' => 4]);
        Product::create(['name' => 'Hirono Figure 2', 'price' => 480.0, 'image_url' => 'collection/hirono/hirono3.png', 'category_id' => 4]);
        Product::create(['name' => 'Hirono Figure 3', 'price' => 480.0, 'image_url' => 'collection/hirono/hirono4.png', 'category_id' => 4]);
        Product::create(['name' => 'Hirono Figure 4', 'price' => 480.0, 'image_url' => 'collection/hirono/hirono5.png', 'category_id' => 4]);
        Product::create(['name' => 'Hirono Figure 5', 'price' => 480.0, 'image_url' => 'collection/hirono/hirono6.png', 'category_id' => 4]);
        Product::create(['name' => 'Hirono Figure 6', 'price' => 480.0, 'image_url' => 'collection/hirono/hirono7.png', 'category_id' => 4]);
        Product::create(['name' => 'Hirono Figure 7', 'price' => 480.0, 'image_url' => 'collection/hirono/hirono8.png', 'category_id' => 4]);
        Product::create(['name' => 'Hirono Figure 8', 'price' => 480.0, 'image_url' => 'collection/hirono/hirono9.png', 'category_id' => 4]);
        Product::create(['name' => 'Hirono Figure 9', 'price' => 480.0, 'image_url' => 'collection/hirono/hirono10.png', 'category_id' => 4]);
        

        Product::create(['name' => 'Twinkle Figurine 1', 'price' => 480.0, 'image_url' => 'collection/twinkle/twinkle2.png', 'category_id' => 5]);
        Product::create(['name' => 'Twinkle Figurine 2', 'price' => 480.0, 'image_url' => 'collection/twinkle/twinkle3.png', 'category_id' => 5]);
        Product::create(['name' => 'Twinkle Figurine 3', 'price' => 480.0, 'image_url' => 'collection/twinkle/twinkle4.png', 'category_id' => 5]);
        Product::create(['name' => 'Twinkle Figurine 4', 'price' => 480.0, 'image_url' => 'collection/twinkle/twinkle5.png', 'category_id' => 5]);
        Product::create(['name' => 'Twinkle Figurine 5', 'price' => 480.0, 'image_url' => 'collection/twinkle/twinkle6.png', 'category_id' => 5]);
        Product::create(['name' => 'Twinkle Figurine 6', 'price' => 480.0, 'image_url' => 'collection/twinkle/twinkle7.png', 'category_id' => 5]);
        Product::create(['name' => 'Twinkle Figurine 7', 'price' => 480.0, 'image_url' => 'collection/twinkle/twinkle8.png', 'category_id' => 5]);
        Product::create(['name' => 'Twinkle Figurine 8', 'price' => 480.0, 'image_url' => 'collection/twinkle/twinkle9.png', 'category_id' => 5]);
        Product::create(['name' => 'Twinkle Figurine 9', 'price' => 480.0, 'image_url' => 'collection/twinkle/twinkle10.png', 'category_id' => 5]);
        
    }
}