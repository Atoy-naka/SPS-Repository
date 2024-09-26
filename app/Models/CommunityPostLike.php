<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPostLike extends Model
{
    use HasFactory;

    protected $table = 'communitypost_likes'; // テーブル名を明示的に指定

    protected $fillable = ['community_posts_id', 'user_id'];

    public function communityPost()
    {
        return $this->belongsTo(CommunityPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
