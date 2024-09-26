<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityPost;
use App\Models\Community;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::all();
        return view('communities.index', compact('communities'));
    }

    public function create()
    {
        return view('communities.create');
    }

    public function store(Request $request)
    {
        $community = Community::create($request->all());
        $community->users()->attach(auth()->user()->id, ['role' => 'leader']);
        return redirect()->route('communities.index');
    }


    public function show(Community $community)
    {
        $posts = $community->communityPosts()->paginate(10);
        return view('communities.show', compact('community', 'posts'));
    }
    
    public function members(Community $community)
    {
        return view('communities.members', compact('community'));
    }
    
    public function join(Community $community)
    {
        $community->users()->attach(auth()->user()->id);
        return redirect()->route('communities.show', $community);
    }
    
    public function leave(Community $community)
    {
        $community->users()->detach(auth()->user()->id);
        return redirect()->route('communities.index');
    }
    
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