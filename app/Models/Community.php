<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function communityPosts()
    {
        return $this->hasMany(CommunityPost::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'community_user')->withPivot('role');
    }

}