<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Kitty Collection'],
            ['category_name' => 'My Melody Collection'],
            ['category_name' => 'Kuromi Collection'],
            ['category_name' => 'Hirono Collection'],
            ['category_name' => 'Twinkle Collection'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
