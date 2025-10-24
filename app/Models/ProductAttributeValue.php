<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    protected $fillable = ['product_id','attribute_id','value'];
    public function product(){ return $this->belongsTo(Product::class); }
    public function attribute(){ return $this->belongsTo(Attribute::class); }
}
