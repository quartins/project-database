<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'email',
        'password',
        'profile_photo',
        'phone',
        'birthday',
        'recipient_name',
        'address_line1',
        'address_line2',
        'district',
        'province',
        'postcode',
        'country',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthday' => 'date',
        ];
    }

    /** ✅ Accessor: ใช้ username เป็น name */
    public function getNameAttribute(): string
    {
        return $this->username ?? '';
    }

    /** ✅ Mutator: บันทึก username ผ่าน name */
    public function setNameAttribute($value): void
    {
        $this->attributes['username'] = $value;
    }

    /** ✅ ความสัมพันธ์กับที่อยู่ผู้ใช้ (user_addresses table) */
    public function addresses()
    {
        return $this->hasMany(\App\Models\Address::class);
    }
}
