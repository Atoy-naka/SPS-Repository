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
        
        $post = CommunityPost::find(intval($post_id));

        $alreadyLiked = CommunityPostLike::where('user_id', $user_id)->where('community_posts_id', intval($post_id))->first();
        //dd($alreadyLiked);
        if (!$alreadyLiked) {
            $like = new CommunityPostLike();
            $like->community_posts_id = intval($post_id);
            $like->user_id = $user_id;
            $like->save();
        } else {
            CommunityPostLike::where('community_posts_id', $post_id)->where('user_id', $user_id)->delete();
            //$alreadyLiked->delete();
        }
        // $post = CommunityPost::where('id', $post_id)->first();
        // dd($post);
        $likesCount = $post->likes->count();
        //dd($likesCount);
        $param = [
            'likesCount' =>  $likesCount,
        ];
        //ビューにいいね数を渡しています。名前は上記のlikesCountとなるため、フロントでlikesCountといった表記で受け取っているのがわかると思います。
        return response()->json($param);
    }
}
