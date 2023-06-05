<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'items_categories', 'category_id', 'item_id');
    }

}
