<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $products = [
            // 🩷 Kitty Collection
            [
                'name' => 'Hello Kitty Figurine ',
                'price' => 480.0,
                'stock_qty' => 10,
                'image_url' => 'collection/kitty/kitty2.png',
                'category_id' => 1,
            ],
            [
                'name' => 'Hello Kitty Figurine ',
                'price' => 430.0,
                'stock_qty' => 8,
                'image_url' => 'collection/kitty/kitty3.png',
                'category_id' => 1,
            ],
            [
                'name' => 'Hello Kitty Figurine ',
                'price' => 430.0,
                'stock_qty' => 8,
                'image_url' => 'collection/kitty/kitty4.png',
                'category_id' => 1,
            ],
            [
                'name' => 'Hello Kitty Figurine ',
                'price' => 430.0,
                'stock_qty' => 8,
                'image_url' => 'collection/kitty/kitty5.png',
                'category_id' => 1,
            ],
            [
                'name' => 'Hello Kitty Figurine ',
                'price' => 430.0,
                'stock_qty' => 8,
                'image_url' => 'collection/kitty/kitty6.png',
                'category_id' => 1,
            ],
            [
                'name' => 'Hello Kitty Figurine ',
                'price' => 430.0,
                'stock_qty' => 8,
                'image_url' => 'collection/kitty/kitty7.png',
                'category_id' => 1,
            ],
            [
                'name' => 'Hello Kitty Figurine ',
                'price' => 430.0,
                'stock_qty' => 8,
                'image_url' => 'collection/kitty/kitty8.png',
                'category_id' => 1,
            ],
            [
                'name' => 'Hello Kitty Figurine ',
                'price' => 430.0,
                'stock_qty' => 8,
                'image_url' => 'collection/kitty/kitty9.png',
                'category_id' => 1,
            ],
            [
                'name' => 'Hello Kitty Figurine ',
                'price' => 430.0,
                'stock_qty' => 8,
                'image_url' => 'collection/kitty/kitty10.png',
                'category_id' => 1,
            ],

            // 💖 My Melody Collection
            [
                'name' => 'My Melody Plush ',
                'price' => 490.0,
                'stock_qty' => 12,
                'image_url' => 'collection/mymelody/mymelody2.png',
                'category_id' => 2,
            ],
            [
                'name' => 'My Melody Plush ',
                'price' => 490.0,
                'stock_qty' => 9,
                'image_url' => 'collection/mymelody/mymelody3.png',
                'category_id' => 2,
            ],
             [
                'name' => 'My Melody Plush ',
                'price' => 490.0,
                'stock_qty' => 9,
                'image_url' => 'collection/mymelody/mymelody4.png',
                'category_id' => 2,
            ],
             [
                'name' => 'My Melody Plush ',
                'price' => 490.0,
                'stock_qty' => 9,
                'image_url' => 'collection/mymelody/mymelody5.png',
                'category_id' => 2,
            ],
             [
                'name' => 'My Melody Plush ',
                'price' => 490.0,
                'stock_qty' => 9,
                'image_url' => 'collection/mymelody/mymelody6.png',
                'category_id' => 2,
            ],
             [
                'name' => 'My Melody Plush ',
                'price' => 490.0,
                'stock_qty' => 9,
                'image_url' => 'collection/mymelody/mymelody7.png',
                'category_id' => 2,
            ],
             [
                'name' => 'My Melody Plush ',
                'price' => 490.0,
                'stock_qty' => 9,
                'image_url' => 'collection/mymelody/mymelody8.png',
                'category_id' => 2,
            ],
             [
                'name' => 'My Melody Plush ',
                'price' => 490.0,
                'stock_qty' => 9,
                'image_url' => 'collection/mymelody/mymelody9.png',
                'category_id' => 2,
            ],
             [
                'name' => 'My Melody Plush ',
                'price' => 490.0,
                'stock_qty' => 9,
                'image_url' => 'collection/mymelody/mymelody10.png',
                'category_id' => 2,
            ],

            // 🖤 Kuromi Collection
            [
                'name' => 'Kuromi Figure 2',
                'price' => 480.0,
                'stock_qty' => 11,
                'image_url' => 'collection/kuromi/kuromi2.png',
                'category_id' => 3,
            ],
            [
                'name' => 'Kuromi Figure 3',
                'price' => 480.0,
                'stock_qty' => 7,
                'image_url' => 'collection/kuromi/kuromi3.png',
                'category_id' => 3,
            ],
             [
                'name' => 'Kuromi Figure 3',
                'price' => 480.0,
                'stock_qty' => 7,
                'image_url' => 'collection/kuromi/kuromi4.png',
                'category_id' => 3,
            ],
             [
                'name' => 'Kuromi Figure 3',
                'price' => 480.0,
                'stock_qty' => 7,
                'image_url' => 'collection/kuromi/kuromi5.png',
                'category_id' => 3,
            ],
             [
                'name' => 'Kuromi Figure 3',
                'price' => 480.0,
                'stock_qty' => 7,
                'image_url' => 'collection/kuromi/kuromi6.png',
                'category_id' => 3,
            ],
             [
                'name' => 'Kuromi Figure 3',
                'price' => 480.0,
                'stock_qty' => 7,
                'image_url' => 'collection/kuromi/kuromi7.png',
                'category_id' => 3,
            ],
             [
                'name' => 'Kuromi Figure 3',
                'price' => 480.0,
                'stock_qty' => 7,
                'image_url' => 'collection/kuromi/kuromi8.png',
                'category_id' => 3,
            ],
             [
                'name' => 'Kuromi Figure 3',
                'price' => 480.0,
                'stock_qty' => 7,
                'image_url' => 'collection/kuromi/kuromi9.png',
                'category_id' => 3,
            ],
             [
                'name' => 'Kuromi Figure 3',
                'price' => 480.0,
                'stock_qty' => 7,
                'image_url' => 'collection/kuromi/kuromi10.png',
                'category_id' => 3,
            ],


            // 🩵 Hirono Collection
            [
                'name' => 'Hirono Figure 2',
                'price' => 480.0,
                'stock_qty' => 10,
                'image_url' => 'collection/hirono/hirono2.png',
                'category_id' => 4,
            ],
            [
                'name' => 'Hirono Figure 3',
                'price' => 480.0,
                'stock_qty' => 8,
                'image_url' => 'collection/hirono/hirono3.png',
                'category_id' => 4,
            ],
             [
                'name' => 'Hirono Figure 3',
                'price' => 480.0,
                'stock_qty' => 8,
                'image_url' => 'collection/hirono/hirono4.png',
                'category_id' => 4,
            ],
             [
                'name' => 'Hirono Figure 3',
                'price' => 480.0,
                'stock_qty' => 8,
                'image_url' => 'collection/hirono/hirono5.png',
                'category_id' => 4,
            ],
             [
                'name' => 'Hirono Figure 3',
                'price' => 480.0,
                'stock_qty' => 8,
                'image_url' => 'collection/hirono/hirono6.png',
                'category_id' => 4,
            ],
             [
                'name' => 'Hirono Figure 3',
                'price' => 480.0,
                'stock_qty' => 8,
                'image_url' => 'collection/hirono/hirono7.png',
                'category_id' => 4,
            ],
             [
                'name' => 'Hirono Figure 3',
                'price' => 480.0,
                'stock_qty' => 8,
                'image_url' => 'collection/hirono/hirono8.png',
                'category_id' => 4,
            ],
             [
                'name' => 'Hirono Figure 3',
                'price' => 480.0,
                'stock_qty' => 8,
                'image_url' => 'collection/hirono/hirono9.png',
                'category_id' => 4,
            ],
             [
                'name' => 'Hirono Figure 3',
                'price' => 480.0,
                'stock_qty' => 8,
                'image_url' => 'collection/hirono/hirono10.png',
                'category_id' => 4,
            ],

            // 🌟 Twinkle Collection
            [
                'name' => 'Twinkle Figurine 2',
                'price' => 480.0,
                'stock_qty' => 10,
                'image_url' => 'collection/twinkle/twinkle2.png',
                'category_id' => 5,
            ],
            [
                'name' => 'Twinkle Figurine 3',
                'price' => 480.0,
                'stock_qty' => 6,
                'image_url' => 'collection/twinkle/twinkle3.png',
                'category_id' => 5,
            ],
             [
                'name' => 'Twinkle Figurine 3',
                'price' => 480.0,
                'stock_qty' => 6,
                'image_url' => 'collection/twinkle/twinkle4.png',
                'category_id' => 5,
            ],
             [
                'name' => 'Twinkle Figurine 3',
                'price' => 480.0,
                'stock_qty' => 6,
                'image_url' => 'collection/twinkle/twinkle5.png',
                'category_id' => 5,
            ],
             [
                'name' => 'Twinkle Figurine 3',
                'price' => 480.0,
                'stock_qty' => 6,
                'image_url' => 'collection/twinkle/twinkle6.png',
                'category_id' => 5,
            ],
             [
                'name' => 'Twinkle Figurine 3',
                'price' => 480.0,
                'stock_qty' => 6,
                'image_url' => 'collection/twinkle/twinkle7.png',
                'category_id' => 5,
            ],
             [
                'name' => 'Twinkle Figurine 3',
                'price' => 480.0,
                'stock_qty' => 6,
                'image_url' => 'collection/twinkle/twinkle8.png',
                'category_id' => 5,
            ],
             [
                'name' => 'Twinkle Figurine 3',
                'price' => 480.0,
                'stock_qty' => 6,
                'image_url' => 'collection/twinkle/twinkle9.png',
                'category_id' => 5,
            ],
             [
                'name' => 'Twinkle Figurine 3',
                'price' => 480.0,
                'stock_qty' => 6,
                'image_url' => 'collection/twinkle/twinkle10.png',
                'category_id' => 5,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}