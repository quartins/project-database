<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'recipient_name', 
        'phone',
        'address_line1', 
        'address_line2',
        'district', 
        'province', 
        'postcode', 
        'country',
        'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
