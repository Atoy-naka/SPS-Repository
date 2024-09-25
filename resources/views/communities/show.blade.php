<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ $community->name }}
                </h2>
                <div class="flex items-center mt-2">
                    @foreach ($community->users->sortByDesc('pivot.created_at')->take(5) as $user)
                        <a href="{{ route('user.profile', $user->id) }}" class="relative -ml-2">
                            <img src="{{ asset($user->profile_photo_path) }}" alt="アイコン" class="profile-icon border-2 border-white">
                        </a>
                    @endforeach
                    <span class="ml-4">{{ $community->users->count() }}人のメンバー</span>
                </div>
                <a href="{{ route('communities.members', $community) }}" class="text-blue-500 hover:underline">メンバー一覧</a>
                <p class="text-gray-600 mt-2">{{ $community->description }}</p>
            </div>
            @if($community->users->contains(auth()->user()))
                <form action="{{ route('communities.leave', $community) }}" method="POST" onsubmit="return confirm('コミュニティを抜けますか？')">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">退会</button>
                </form>
            @else
                <script>
                    alert('参加ボタンを押し、コミュニティに参加してください');
                    window.location.href = '/communities';
                </script>
            @endif
        </div>
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

        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            margin-top: 10px;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .content {
            margin-top: 20px;
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

        .fa-star {
            font-size: 30px;
        }
    </style>
    <a href="{{ route('communities.posts.create', ['community' => $community->id]) }}" class="btn-primary">投稿</a>
    <div class="content">
        <div class='posts'>
            @foreach ($posts->sortByDesc('created_at') as $post)
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
                            <i class="fa-solid fa-star like-btn {{ $post->isLikedByAuthUser() ? 'liked' : '' }}" id="{{ $post->id }}" data-post-type="{{ $community->id }}"></i>
                            <p class="count-num">{{ $post->likes->count() }}</p>
                        </div>
                        <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="deletePost({{ $post->id }})">削除</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $posts->links() }}
        </div>
    </div>
    <script>
        function deletePost(id) {
            'use strict'
            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
        
        const likeBtns = document.querySelectorAll('.like-btn');
        likeBtns.forEach(likeBtn => {
            likeBtn.addEventListener('click', async (e) => {
                const clickedEl = e.target;
                clickedEl.classList.toggle('liked');
                const postId = e.target.id;
                const postType = e.target.getAttribute('data-post-type');
                const res = await fetch('/communities/{communities}/posts/like', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ post_id: postId, post_type: postType })
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
