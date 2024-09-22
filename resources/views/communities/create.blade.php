<x-app-layout>
    <x-slot name="header">
        投稿
    </x-slot>
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
        }

        .post-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            background-color: #fff;
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .profile-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 12px;
        }

        .user-name {
            font-weight: bold;
            font-size: 1.2em;
        }

        .post-title {
            font-size: 1.2em;
            margin-bottom: 8px;
        }

        .post-body {
            font-size: 1em;
            color: #333;
        }

        .post-image {
            width: 100%;
            height: auto;
            margin-top: 8px;
            border-radius: 8px;
            max-width: 300px;
        }

        .rounded-circle {
            border-radius: 50%;
        }

        .follow-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .follow-btn.following {
            background-color: #28a745;
        }

        .profile-header {
            position: relative;
        }
    </style>
    <h1>Post</h1>
    <form action="{{ route('communities.posts.store', $community) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="category">
            <h2>投稿カテゴリ</h2>
            <select name="post[category_id]">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="title">
            <h2>タイトル</h2>
            <input type="text" name="post[title]" placeholder="タイトルを入力" value="{{ old('post.title') }}"/>
            <p class="title__error" style="color:red">{{ $errors->first('post.title') }}</p>
        </div>
        <div class="body">
            <h2>本文</h2>
            <textarea name="post[body]" placeholder="本文を入力">{{ old('post.body') }}</textarea>
            <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
        </div>
        <div class="image">
            <input type="file" name="image">
        </div>
        <input type="submit" value="投稿"/>
    </form>
    <div class="footer">
        <a href="{{ route('communities.show', $community) }}">戻る</a>
    </div>
</x-app-layout>
