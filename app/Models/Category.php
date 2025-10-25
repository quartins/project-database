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
}