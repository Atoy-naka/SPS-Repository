<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityComment;
use App\Models\CommunityPost;

class CommunityCommentController extends Controller
{
    public function store(Request $request, $communityId, $postId)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $post = CommunityPost::findOrFail($postId);

        $comment = new CommunityComment();
        $comment->body = $request->body;
        $comment->user_id = auth()->id();
        $comment->community_post_id = $post->id;
        $comment->save();

        return redirect()->route('communities.posts.comments', [$communityId, $postId]);
    }
}
