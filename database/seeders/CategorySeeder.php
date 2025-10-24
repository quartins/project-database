<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name' => 'Kitty Collection'],
            ['name' => 'My Melody Collection'],
            ['name' => 'Kuromi Collection'],
            ['name' => 'Hirono Collection'],
            ['name' => 'Twinkle Collection'],
        ];

        foreach ($rows as $row) {
            Category::firstOrCreate(['name' => $row['name']], $row);
        }
    }
}
