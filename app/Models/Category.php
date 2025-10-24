<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    use HasFactory;

    // ✅ Primary Key คือ 'id' ซึ่งเป็นค่าเริ่มต้น ไม่ต้องระบุ
    // protected $primaryKey = 'id';

    // ✅ แก้ไข $fillable ให้ตรงกับคอลัมน์ในฐานข้อมูล และ Seeder
    protected $fillable = [
        'name',
        'image_url',
    ];

    public function products()
    {
        // ✅ ถ้า Primary Key ของทั้งสองตารางเป็น id/category_id ตาม Laravel convention ก็ใช้แบบสั้นได้
        return $this->hasMany(Product::class);
    }

    public function getThumbSrcAttribute(): string
{
    $first = $this->products->first();           // จะได้มาจาก eager load (ดูข้อ 2)
    if ($first && $first->image_url) {
        return asset($first->image_url);         // พาธใน DB เป็น 'collection/...'
    }
    return asset('images/placeholder.png');      // ทำไฟล์ fallback นี้ไว้ที่ public/images
}

public function attributes()
{
    return $this->belongsToMany(\App\Models\Attribute::class, 'category_attribute')
                ->withPivot(['is_required', 'sort_order'])
                ->withTimestamps()
                ->orderBy('category_attribute.sort_order');
}

}