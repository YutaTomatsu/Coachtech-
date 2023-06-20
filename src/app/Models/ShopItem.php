<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{
    protected $table = 'shops_items';

    protected $fillable = [
        'id',
        'item_id',
        'shop_id',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
