<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
        'prefecture', //都道府県
        'city', //市
        'district', //区町村
        'bio', //自己紹介文
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];    
    
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followee_user_id', 'follower_user_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_user_id', 'followee_user_id');
    }
    
    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

    public function getFollowingCountAttribute()
    {
        return $this->following()->count();
    }
    
    public function communities()
    {
        return $this->belongsToMany(Community::class, 'community_user', 'user_id', 'community_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
