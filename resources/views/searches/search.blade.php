<x-app-layout>
    <script src="https://kit.fontawesome.com/ee97774e40.js" crossorigin="anonymous"></script>
    <x-slot name="header">
        SEARCH
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

        .liked {
            color: orangered;
            transition: .2s;
        }

        .flexbox {
            align-items: center;
            display: flex;
        }

        .count-num {
            font-size: 20px;
            margin-left: 10px;
        }

        .fa-star, .fa-comment-dots {
            font-size: 30px;
            cursor: pointer;
        }

        .comment-btn {
            margin-left: 20px;
        }

        .fixed-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
    <h1>投稿検索</h1>
    <form action="{{ route('search') }}" method="GET">
        <input type="text" name="keyword" placeholder="キーワードを入力" value="{{ request()->input('keyword') }}"/>
        <button type="submit">[検索]</button>
    </form>
    <div class='posts'>
        @if(request()->has('keyword'))
            @if($posts->isEmpty())
                <p>該当する投稿がありません。</p>
            @else
                @foreach($posts as $post)
                <div class='post-card'>
                    <div class='post-header'>
                        @if ($post->user)
                            <a href="{{ route('user.profile', $post->user->id) }}">
                                <img src="{{ asset($post->user->profile_photo_path) }}" alt="アイコン" class="profile-icon">
                            </a>
                            <a href="{{ route('user.profile', $post->user->id) }}" class="user-name">{{ $post->user->name }}</a>
                        @else
                            <span class="user-name">Unknown User</span>
                        @endif
                    </div>
                    <div class='post-content'>
                        <h2 class='title'>
                            <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                        </h2>
                        @if ($post->category)
                            <a href="/categories/{{ $post->category->id }}">{{ $post->category->name }}</a>
                        @endif
                        <p class='body'>{{ $post->body }}</p>
                        @if ($post->image_url)
                            <img src="{{ $post->image_url }}" alt="投稿画像" class="post-image">
                        @endif
                        <div class="flexbox">
                            <i class="fa-solid fa-star like-btn {{ $post->isLikedByAuthUser() ? 'liked' : '' }}" id="{{ $post->id }}"></i>
                            <p class="count-num">{{ $post->likes->count() }}</p>
                            <a href="{{ route('posts.comments', $post->id) }}" class="comment-btn">
                                <i class="fa-regular fa-comment-dots"></i>
                            </a>
                            <p class="count-num">{{ $post->comments->count() }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        @endif
    </div>
    <script>
        const likeBtns = document.querySelectorAll('.like-btn');
        likeBtns.forEach(likeBtn => {
            likeBtn.addEventListener('click', async (e) => {
                const clickedEl = e.target;
                clickedEl.classList.toggle('liked');
                const postId = e.target.id;
                const res = await fetch('/post/like', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ post_id: postId })
                })
                .then((res) => res.json())
                .then((data) => {
                    clickedEl.nextElementSibling.innerHTML = data.likesCount;
                })
                .catch(() => alert('処理が失敗しました。画面を再読み込みし、通信環境の良い場所で再度お試しください。'));
            });
        });
    </script>
</x-app-layout>
