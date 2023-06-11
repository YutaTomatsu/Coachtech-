<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'seller_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }


    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id','id');
    }

}
