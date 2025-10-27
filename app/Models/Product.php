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
        'category_id'
    ];

    // แก้ตรงนี้ — ลบ cast decimal ของ size_cm ออก
    protected $casts = [
        'price' => 'decimal:2',
        'stock_qty' => 'integer',
        // 'size_cm' => 'decimal:2', 
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function materials()
    {
        return $this->hasMany(ProductMaterial::class);
    }

    public function inStock(): bool
    {
        return (int)($this->stock_qty ?? 0) > 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return '฿ ' . number_format((float)$this->price, 2);
    }

    // ✅ แก้ฟังก์ชันนี้ให้รองรับทั้ง string และ numeric
    public function getFormattedSizeAttribute(): ?string
    {
        if (empty($this->size_cm)) {
            return null;
        }

        // ถ้าเป็นตัวเลข (เช่น 15 หรือ 15.0)
        if (is_numeric($this->size_cm)) {
            return rtrim(number_format((float)$this->size_cm, 2), '.0') . ' cm';
        }

        // ถ้าเป็นข้อความอยู่แล้ว เช่น "15 cm"
        return $this->size_cm;
    }

    protected static function booted()
    {
        static::saving(function (Product $p) {
            if (empty($p->slug) && !empty($p->name)) {
                $base = Str::slug($p->name);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->where('id', '<>', $p->id)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $p->slug = $slug;
            }
            if (empty($p->sku)) {
                $p->sku = 'SKU-' . strtoupper(Str::random(8));
            }
        });
    }

    // helper สำหรับ route: {id}-{slug}
    public function getRouteKeyCompositeAttribute(): string
    {
        return "{$this->id}-{$this->slug}";
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->name ?? '');
    }
}
