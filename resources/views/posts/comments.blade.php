<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                コメント
            </h2>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">戻る</a>
        </div>
    </x-slot>

    <div class="container">
        <div class="post-card">
            <div class="post-header">
                <img src="{{ asset($post->user->profile_photo_path) }}" alt="アイコン" class="profile-icon">
                <span class="user-name">{{ $post->user->name }}</span>
            </div>
            <div class="post-content">
                <h2 class="title">{{ $post->title }}</h2>
                <p class="body">{{ $post->body }}</p>
                @if ($post->image_url)
                    <img src="{{ $post->image_url }}" alt="投稿画像" class="post-image">
                @endif
            </div>
        </div>

        <div class="comments">
            @foreach ($post->comments as $comment)
                <div class="comment">
                    <div class="comment-header">
                        <img src="{{ asset($comment->user->profile_photo_path) }}" alt="アイコン" class="profile-icon">
                        <div class="comment-body">
                            <span class="user-name">{{ $comment->user->name }}</span>
                            <p>{{ $comment->body }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <form action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <textarea name="body" rows="3" class="form-control" placeholder="コメントを入力"></textarea>
            <button type="submit" class="btn btn-primary">送信</button>
        </form>
    </div>
</x-app-layout>

<style>
    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

    .post-content {
        margin-top: 12px;
    }

    .title {
        font-size: 1.5em;
        margin-bottom: 8px;
    }

    .body {
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

    .comments {
        margin-top: 20px;
    }

    .comment {
        display: flex;
        align-items: flex-start;
        margin-bottom: 16px;
        padding: 10px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .comment-header {
        display: flex;
        align-items: flex-start;
    }

    .comment-body {
        display: flex;
        flex-direction: column;
        margin-left: 12px;
    }

    .comment-body p {
        margin-top: 4px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }
</style>
