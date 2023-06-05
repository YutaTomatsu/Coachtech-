<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $table = 'items_categories';
    protected $fillable = [
        'id',
        'item_id',
        'category_id',
    ];
}
