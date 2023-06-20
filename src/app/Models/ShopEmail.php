<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopEmail extends Model
{
    use HasFactory;

    protected $table = 'shops_emails';

    protected $fillable = [
        'user_id',
        'shop_id',
        'content',
        'sent_by',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
