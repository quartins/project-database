<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductDetailsSeeder extends Seeder
{
    public function run(): void
    {
        // 🩷 Hello Kitty 
        Product::where('image_url', 'collection/kitty/kitty2.png')->update([
            'description' => 'Classic Hello Kitty figurine in red dress and bow.',
            'size_cm' => '15 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty3.png')->update([
            'description' => 'Hello Kitty sitting figure with glossy finish.',
            'size_cm' => '14 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty4.png')->update([
            'description' => 'Limited Hello Kitty figurine wearing pink hat.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty5.png')->update([
            'description' => 'Limited Hello Kitty figurine wearing pink hat.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty6.png')->update([
            'description' => 'Limited Hello Kitty figurine wearing pink hat.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty7.png')->update([
            'description' => 'Limited Hello Kitty figurine wearing pink hat.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty8.png')->update([
            'description' => 'Limited Hello Kitty figurine wearing pink hat.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty9.png')->update([
            'description' => 'Limited Hello Kitty figurine wearing pink hat.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/kitty/kitty10.png')->update([
            'description' => 'Limited Hello Kitty figurine wearing pink hat.',
            'size_cm' => '16 cm',
        ]);

        // 💖 My Melody
        Product::where('image_url', 'collection/mymelody/mymelody2.png')->update([
            'description' => 'My Melody plush with soft cotton texture.',
            'size_cm' => '20 cm',
        ]);

        Product::where('image_url', 'collection/mymelody/mymelody3.png')->update([
            'description' => 'Standing My Melody plush, perfect for hugging.',
            'size_cm' => '22 cm',
        ]);

         Product::where('image_url', 'collection/mymelody/mymelody4.png')->update([
            'description' => 'Standing My Melody plush, perfect for hugging.',
            'size_cm' => '22 cm',
        ]);

         Product::where('image_url', 'collection/mymelody/mymelody5.png')->update([
            'description' => 'Standing My Melody plush, perfect for hugging.',
            'size_cm' => '22 cm',
        ]);

         Product::where('image_url', 'collection/mymelody/mymelody6.png')->update([
            'description' => 'Standing My Melody plush, perfect for hugging.',
            'size_cm' => '22 cm',
        ]);

         Product::where('image_url', 'collection/mymelody/mymelody7.png')->update([
            'description' => 'Standing My Melody plush, perfect for hugging.',
            'size_cm' => '22 cm',
        ]);

         Product::where('image_url', 'collection/mymelody/mymelody8.png')->update([
            'description' => 'Standing My Melody plush, perfect for hugging.',
            'size_cm' => '22 cm',
        ]);

         Product::where('image_url', 'collection/mymelody/mymelody9.png')->update([
            'description' => 'Standing My Melody plush, perfect for hugging.',
            'size_cm' => '22 cm',
        ]);

         Product::where('image_url', 'collection/mymelody/mymelody10.png')->update([
            'description' => 'Standing My Melody plush, perfect for hugging.',
            'size_cm' => '22 cm',
        ]);

        // 🖤 Kuromi
        Product::where('image_url', 'collection/kuromi/kuromi2.png')->update([
            'description' => 'Kuromi figure with glossy PVC finish.',
            'size_cm' => '14 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi3.png')->update([
            'description' => 'Limited Kuromi figure holding purple heart.',
            'size_cm' => '13 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi4.png')->update([
            'description' => 'Limited Kuromi figure holding purple heart.',
            'size_cm' => '13 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi5.png')->update([
            'description' => 'Limited Kuromi figure holding purple heart.',
            'size_cm' => '13 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi6.png')->update([
            'description' => 'Limited Kuromi figure holding purple heart.',
            'size_cm' => '13 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi7.png')->update([
            'description' => 'Limited Kuromi figure holding purple heart.',
            'size_cm' => '13 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi8.png')->update([
            'description' => 'Limited Kuromi figure holding purple heart.',
            'size_cm' => '13 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi9.png')->update([
            'description' => 'Limited Kuromi figure holding purple heart.',
            'size_cm' => '13 cm',
        ]);

        Product::where('image_url', 'collection/kuromi/kuromi10.png')->update([
            'description' => 'Limited Kuromi figure holding purple heart.',
            'size_cm' => '13 cm',
        ]);

        // 🩵 Hirono
        Product::where('image_url', 'collection/hirono/hirono2.png')->update([
            'description' => 'Hirono collectible figure with pastel blue tones.',
            'size_cm' => '17 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono3.png')->update([
            'description' => 'Hirono limited edition with detailed base.',
            'size_cm' => '18 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono4.png')->update([
            'description' => 'Hirono collectible figure with pastel blue tones.',
            'size_cm' => '17 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono5.png')->update([
            'description' => 'Hirono collectible figure with pastel blue tones.',
            'size_cm' => '17 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono6.png')->update([
            'description' => 'Hirono collectible figure with pastel blue tones.',
            'size_cm' => '17 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono7.png')->update([
            'description' => 'Hirono collectible figure with pastel blue tones.',
            'size_cm' => '17 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono8.png')->update([
            'description' => 'Hirono collectible figure with pastel blue tones.',
            'size_cm' => '17 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono9.png')->update([
            'description' => 'Hirono collectible figure with pastel blue tones.',
            'size_cm' => '17 cm',
        ]);

        Product::where('image_url', 'collection/hirono/hirono10.png')->update([
            'description' => 'Hirono collectible figure with pastel blue tones.',
            'size_cm' => '17 cm',
        ]);

        // 🌟 Twinkle
        Product::where('image_url', 'collection/twinkle/twinkle2.png')->update([
            'description' => 'Twinkle collectible with cosmic style hat.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle3.png')->update([
            'description' => 'Twinkle collectible with cosmic style hat.',
            'size_cm' => '16 cm',
        ]);

         Product::where('image_url', 'collection/twinkle/twinkle4.png')->update([
            'description' => 'Twinkle collectible with cosmic style hat.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle5.png')->update([
            'description' => 'Twinkle collectible with cosmic style hat.',
            'size_cm' => '16 cm',
        ]);

         Product::where('image_url', 'collection/twinkle/twinkle6.png')->update([
            'description' => 'Twinkle collectible with cosmic style hat.',
            'size_cm' => '16 cm',
        ]);

         Product::where('image_url', 'collection/twinkle/twinkle7.png')->update([
            'description' => 'Twinkle collectible with cosmic style hat.',
            'size_cm' => '16 cm',
        ]);

        Product::where('image_url', 'collection/twinkle/twinkle8.png')->update([
            'description' => 'Twinkle collectible with cosmic style hat.',
            'size_cm' => '16 cm',
        ]);

         Product::where('image_url', 'collection/twinkle/twinkle9.png')->update([
            'description' => 'Twinkle collectible with cosmic style hat.',
            'size_cm' => '16 cm',
        ]);

         Product::where('image_url', 'collection/twinkle/twinkle10.png')->update([
            'description' => 'Twinkle collectible with cosmic style hat.',
            'size_cm' => '16 cm',
        ]);
    }
}
