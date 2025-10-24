<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class BulkProductDetailsSeeder extends Seeder
{
    public function run(): void
    {
        $materialsByCat = [
            'Kitty Collection'     => ['Cotton 80','Polyester 20'],
            'My Melody Collection' => ['Cotton 80','Polyester 20'],
            'Kuromi Collection'    => ['PVC 70','ABS 30'],
            'Hirono Collection'    => ['PVC 70','ABS 30'],
            'Twinkle Collection'   => ['PVC 70','ABS 30'],
        ];

        Product::with(['category','materials','attributeValues','category.attributes'])
            ->chunkById(200, function($products) use ($materialsByCat) {
                foreach ($products as $p) {
                    $catName = $p->category?->name ?? '';

                    // size_cm (เติมให้มีค่า ถ้ายังว่าง)
                    if (is_null($p->size_cm)) {
                        $p->size_cm = match ($catName) {
                            'Kuromi Collection','Hirono Collection','Twinkle Collection' => 18, // figure
                            default => 15, // plush
                        };
                        $p->save();
                    }

                    // product_materials (มีแล้วไม่ซ้ำ)
                    if ($p->materials()->count() === 0) {
                        $preset = $materialsByCat[$catName] ?? ['Mixed 100'];
                        $rows = collect($preset)->map(function($txt){
                            if (preg_match('/^(.+?)\s+(\d+)\s*$/u',$txt,$m)) {
                                return ['material'=>trim($m[1]), 'percent'=>(int)$m[2]];
                            }
                            return ['material'=>$txt, 'percent'=>null];
                        })->all();
                        $p->materials()->createMany($rows);
                    }

                    // attribute values ตาม category->attributes
                    foreach ($p->category?->attributes ?? [] as $attr) {
                        $val = null;
                        if ($attr->name==='วัสดุ') {
                            $val = $p->materials()->get()->map(fn($m)=> $m->material.(is_null($m->percent)?'':" {$m->percent}%"))->implode(' / ');
                        } elseif ($attr->name==='ความสูง') {
                            $val = (string)($p->size_cm ?? 0);
                        } elseif ($attr->name==='น้ำหนัก') {
                            $val = (string)(50 + rand(0,250)); // g
                        } elseif ($attr->name==='ขนาด') {
                            $h = $p->size_cm ?? 10; $w = max(2, round($h*0.6,1)); $val = "{$w} × {$h}";
                        }
                        if ($val !== null && $val!=='') {
                            $p->attributeValues()->updateOrCreate(
                                ['attribute_id'=>$attr->id],
                                ['value'=>$val]
                            );
                        }
                    }
                }
            });
    }
}
