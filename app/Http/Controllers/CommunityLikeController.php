<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\CommunityPostLike;
use Illuminate\Http\Request;

class CommunityLikeController extends Controller
{
    public function likePost(Request $request)
    {
        $user_id = \Auth::id();
        $post_id = $request->post_id;

        $post = CommunityPost::find($post_id);

        $alreadyLiked = CommunityPostLike::where('user_id', $user_id)->where('community_posts_id', $post_id)->first();

        if (!$alreadyLiked) {
            $like = new CommunityPostLike();
            $like->community_posts_id = $post_id;
            $like->user_id = $user_id;
            $like->save();
        } else {
            CommunityPostLike::where('community_posts_id', $post_id)->where('user_id', $user_id)->delete();
        }

        $likesCount = $post->likes->count();

        return response()->json(['likesCount' => $likesCount]);
    }
}
