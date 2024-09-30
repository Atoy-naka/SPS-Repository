<?php

namespace App\Http\Controllers;

use App\Models\CommunityPost;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use Cloudinary;
use Illuminate\Support\Facades\Auth;

class CommunityPostController extends Controller
{
    public function create(Community $community, Category $category)
    {
        return view('communities.postcreate')->with(['community' => $community, 'categories' => $category->get()]);
    }

    public function store(PostRequest $request, Community $community)
    {
        $input = $request['post'];
        $input['user_id'] = Auth::id(); // 現在のユーザーのIDを設定
        $input['community_id'] = $community->id; // コミュニティIDを設定

        if($request->file('image')){ //画像ファイルが送られた時だけ処理が実行される
            $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $input += ['image_url' => $image_url];
        }
        $post = new CommunityPost();
        $post->fill($input)->save();
        return redirect()->route('communities.show', $community);
    }
    
    public function show($communityId, $postId)
    {
        $post = CommunityPost::with('communityComments.user')->findOrFail($postId);
        return view('communities.show', compact('post'));
    }
    
    public function comments($communityId, $postId)
    {
        $post = CommunityPost::with('communityComments.user')->findOrFail($postId);
        return view('communities.comments', compact('post'));
    }
}
