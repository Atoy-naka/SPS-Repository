<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommunityPostLike;

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
        return $this->hasMany(CommunityPostLike::class, 'community_posts_id');
    }
    
    public function communitypost_likes()
    {
        return $this->hasMany(User::class, 'communitypost_likes');
    }
    
    public function communityComments()
    {
        return $this->hasMany(CommunityComment::class);
    }

    public function isLikedByAuthUser() :bool
    {
        $authUserId = \Auth::id();
        $likersArr = array();

        foreach($this->likes as $postLike){
            array_push($likersArr, $postLike->user_id);
        }

        if (in_array($authUserId,$likersArr)){
            //存在したらいいねをしていることになるため、trueを返す
            return true;
        }else{
            return false;
        }
    }
}
