<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStaff extends Model
{
    protected $table = 'users_staffs';

    protected $fillable = [
        'id',
        'user_id',
        'staff_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
