<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mylist;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'item_name',
        'price',
        'image',
        'about',
    ];

    public function mylists()
    {
        return $this->hasMany(Mylist::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'items_categories', 'item_id', 'category_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
