<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $post = Post::findOrFail($postId);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = auth()->id();
        $comment->post_id = $post->id;
        $comment->save();

        // Pusherを使ってリアルタイム通知を送信
        event(new \App\Events\CommentPosted($comment));

        return redirect()->route('posts.comments', $postId);
    }

    public function index($postId)
    {
        $post = Post::with('comments.user')->findOrFail($postId);
        return view('posts.comments', compact('post'));
    }

}
