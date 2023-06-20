<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Item;
use App\Models\Admin;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'icon',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function mylists()
    {
        return $this->belongsToMany(Item::class, 'mylists', 'user_id', 'item_id')->withTimestamps();
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function isAdmin()
    {
        return $this->admin !== null && $this->admin->role === 'admin';
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'user_id');
    }

    public function isFollowing($sellerId)
    {
        return $this->follows()->where('seller_id', $sellerId)->exists();
    }

    public function userstaff()
    {
        return $this->hasMany(UserStaff::class);
    }

}