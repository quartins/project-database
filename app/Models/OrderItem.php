<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id','product_id','qty','unit_price','line_total'];

    protected static function booted()
    {
        static::saving(function (OrderItem $item) {
            $item->line_total = (float)$item->unit_price * (int)$item->qty;
        });
        static::saved(function (OrderItem $item) { $item->order?->recalc(); });
        static::deleted(function (OrderItem $item) { $item->order?->recalc(); });
    }

    public function order(){ return $this->belongsTo(Order::class); }
    public function product(){ return $this->belongsTo(Product::class); }
}