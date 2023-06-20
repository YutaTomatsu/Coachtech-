<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'shop_id',
        'coupon_name',
        'discount_type',
        'discount_value',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
