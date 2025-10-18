<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Kitty',
            'image_url' => 'collection/kitty/kitty1.png', // เพิ่ม Path รูปภาพหลักของหมวดหมู่
        ]);
        Category::create([
            'name' => 'My Melody',
            'image_url' => 'collection/mymelody/mymelody1.png',
        ]);
        Category::create([
            'name' => 'Kuromi',
            'image_url' => 'collection/kuromi/kuromi1.png',
        ]);
        Category::create([
            'name' => 'Hirono',
            'image_url' => 'collection/hirono/hirono1.png',
        ]);
        Category::create([
            'name' => 'Twinkle',
            'image_url' => 'collection/twinkle/twinkle1.png',
        ]);
    }
}