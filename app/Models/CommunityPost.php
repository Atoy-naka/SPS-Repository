<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_id',
        'user_id',
        'title',
        'body',
        'image_url',
    ];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }
    
    public function communitypost_likes()
    {
        return $this->hasMany(CommunityPostLike::class, 'community_post_id');
    }

    public function isLikedByAuthUser() :bool
    {
        $authUserId = \Auth::id();
        $likersArr = array();

        foreach($this->likes as $postLike){
            array_push($likersArr, $postLike->user_id);
        }

        return in_array($authUserId, $likersArr);
    }
}
