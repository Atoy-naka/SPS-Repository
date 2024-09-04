<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Category;

class PostController extends Controller
{
    public function index(Post $post)
    {
        return view('posts.index')->with(['posts' => $post->getPaginateByLimit()]);
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
    
    //検索機能を実装するメソッド
    public function search(Request $request)
    {
        // 検索ボックスに入力されたキーワードを取得
        $keyword = $request->input('keyword'); 
        
        // キーワードが入力されている場合、タイトルまたは本文に部分一致する投稿を検索
        if ($keyword) {
            $posts = Post::where('title', 'LIKE', "%{$keyword}%")
                         ->orWhere('body', 'LIKE', "%{$keyword}%")
                         ->paginate(10); // ページネーションを設定
        } else {
            // キーワードが入力されていない場合、空のコレクションを返す
            $posts = collect(); // 空のコレクションを設定
        }
        
        //検索結果をビューに渡す
        return view('posts.search', compact('posts'));
    }

    // 検索した投稿の詳細画面を表示するメソッド
    public function searchshow(Post $post)
    {
        return view('posts.searchshow')->with(['post' => $post]);
    }
}
    
