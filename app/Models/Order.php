<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','recipient_name','phone','address_line1','address_line2',
        'district','province','postcode','country',
        'subtotal','shipping_fee','discount','total','coupon_code','status','paid_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_fee' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function items(){ return $this->hasMany(OrderItem::class); }
    public function user(){ return $this->belongsTo(User::class); }

    public function recalc(): void {
        $this->subtotal = $this->items()->sum('line_total');
        $this->total = max(0, $this->subtotal + ($this->shipping_fee ?? 0) - ($this->discount ?? 0));
        $this->save();
    }

    public function isPaid(): bool { return $this->status === 'paid'; }

    public function shippingAddress()
    {
        return $this->belongsTo(\App\Models\Address::class, 'shipping_address_id');
    }

}