<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use Cloudinary;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Post $post)
    {
        $posts = $post->getPaginateByLimit(); // getPaginateByLimitメソッドを使用
        return view('posts.index')->with(['posts' => $posts]);
    }

    public function show(Post $post)
    {
        return view('posts.show')->with(['post' => $post]);
    }

    public function create(Category $category)
    {
        return view('posts.create')->with(['categories' => $category->get()]);
    }

    public function store(Post $post, PostRequest $request)
    {
        $input = $request['post'];
        $input['user_id'] = Auth::id(); // 現在のユーザーのIDを設定

        if($request->file('image')){ //画像ファイルが送られた時だけ処理が実行される
            $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $input += ['image_url' => $image_url];
        }
        $post->fill($input)->save();
        return redirect('/posts/' . $post->id);
    }

    public function edit(Post $post)
    {
        return view('posts.edit')->with(['post' => $post]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $input_post = $request['post'];
        $post->fill($input_post)->save();
        return redirect('/posts/' . $post->id);
    }

    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword'); 
        
        if ($keyword) {
            $posts = Post::where('title', 'LIKE', "%{$keyword}%")
                         ->orWhere('body', 'LIKE', "%{$keyword}%")
                         ->paginate(10);
        } else {
            $posts = collect();
        }
        
        return view('searches.search', compact('posts'));
    }

    public function searchshow(Post $post)
    {
        return view('searches.searchshow')->with(['post' => $post]);
    }
    
    public function followingPosts()
    {
        $user = Auth::user();
        $followingIds = $user->following()->pluck('followee_user_id');
        $posts = Post::whereIn('user_id', $followingIds)->orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index')->with(['posts' => $posts]);
    }

}