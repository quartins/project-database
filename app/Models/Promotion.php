<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'discount_percent', 'applies_to', 'is_active', 'start_date', 'end_date'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'promotion_collections');
    }
}
