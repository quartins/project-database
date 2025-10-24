<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'brand',
        'description',
        'price',
        'size_cm',
        'stock_qty',
        'image_url',
        'category_id',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'stock_qty' => 'integer',
        'size_cm'   => 'decimal:2',
    ];

    // -------- Relationships --------
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function materials()
    {
        return $this->hasMany(ProductMaterial::class);
    }

    // -------- Helpers / Accessors --------
    public function inStock(): bool
    {
        return (int)($this->stock_qty ?? 0) > 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '฿ ' . number_format((float) $this->price, 2);
    }

    public function getFormattedSizeAttribute(): ?string
    {
        if (is_null($this->size_cm)) return null;
        return 'Approximately ' . rtrim(rtrim(number_format($this->size_cm, 2), '0'), '.') . ' cm tall';
    }

    // ใช้ค่า slug/sku จาก DB เป็นหลัก
    protected static function booted()
    {
        static::saving(function (Product $p) {
            // เติม slug อัตโนมัติถ้ายังว่าง (และรักษา uniqueness)
            if (empty($p->slug) && !empty($p->name)) {
                $base = Str::slug($p->name);
                $slug = $base; $i = 1;
                while (static::where('slug', $slug)->where('id', '<>', $p->id)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $p->slug = $slug;
            }

            // เติม SKU อัตโนมัติถ้ายังว่าง
            if (empty($p->sku)) {
                $p->sku = 'SKU-' . strtoupper(Str::random(8));
            }
        });
    }

    // สำหรับ route helper {id}-{slug} (ถ้าจะใช้)
    public function getRouteKeyCompositeAttribute(): string
    {
        return "{$this->id}-{$this->slug}";
    }

    public function attributeValues()
{
    // ชี้ไปที่ตาราง product_attribute_values
    return $this->hasMany(\App\Models\ProductAttributeValue::class, 'product_id')
                ->with('attribute'); // เพื่อดึงชื่อ/หน่วยของแอตทริบิวต์มาพร้อมกัน
}
}
