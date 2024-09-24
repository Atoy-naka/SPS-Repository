<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\CommunityPost;
use App\Models\PostLike;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likePost(Request $request)
    {
        $user_id = \Auth::id();
        $post_id = $request->post_id;
        $post_type = $request->post_type; // 'post' or 'community_post'

        if ($post_type === 'post') {
            $post = Post::find($post_id);
        } else {
            $post = CommunityPost::find($post_id);
        }

        $alreadyLiked = PostLike::where('user_id', $user_id)->where('post_id', $post_id)->first();

        if (!$alreadyLiked) {
            $like = new PostLike();
            $like->post_id = $post_id;
            $like->user_id = $user_id;
            $like->save();
        } else {
            PostLike::where('post_id', $post_id)->where('user_id', $user_id)->delete();
        }

        $likesCount = $post->likes->count();

        return response()->json(['likesCount' => $likesCount]);
    }
}
