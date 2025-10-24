<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = ['name','unit','input_type'];
    public function categories() {
        return $this->belongsToMany(Category::class, 'category_attribute')
            ->withPivot(['is_required','sort_order'])->withTimestamps()
            ->withTimestamps();
    }
}
