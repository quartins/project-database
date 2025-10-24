<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;
use App\Models\Category;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        $mat = Attribute::firstOrCreate(['name'=>'วัสดุ'],     ['unit'=>null,'input_type'=>'text']);
        $hgt = Attribute::firstOrCreate(['name'=>'ความสูง'],   ['unit'=>'cm','input_type'=>'number']);
        $wgt = Attribute::firstOrCreate(['name'=>'น้ำหนัก'],   ['unit'=>'g','input_type'=>'number']);
        $siz = Attribute::firstOrCreate(['name'=>'ขนาด'],      ['unit'=>'cm','input_type'=>'text']);

        $map = [
            'Kitty Collection'      => [$mat,$hgt],      // ตัวอย่าง: Kitty เป็น plush
            'My Melody Collection'  => [$mat,$hgt],
            'Kuromi Collection'     => [$mat,$hgt,$wgt],// ตัวอย่าง: figure
            'Hirono Collection'     => [$mat,$hgt,$wgt],
            'Twinkle Collection'    => [$mat,$hgt,$wgt],
        ];

        foreach ($map as $catName => $attrs) {
            if ($cat = Category::where('name',$catName)->first()) {
                $payload=[]; $i=1;
                foreach ($attrs as $a) $payload[$a->id] = ['sort_order'=>$i++];
                $cat->attributes()->syncWithoutDetaching($payload);
            }
        }
    }
}
