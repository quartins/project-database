<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    // CartItem อยู่ภายใน Cart ไหน
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    //  CartItem อ้างถึง Product ไหน
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
