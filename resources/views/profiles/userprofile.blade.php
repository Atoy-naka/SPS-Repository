<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="profile-header p-6">
                    <img src="{{ $user->profile_photo_path }}" class="rounded-circle" alt="Profile Photo" style="width: 150px; height: 150px; object-fit: cover;">
                    <h2>USER NAME:{{ $user->name }}</h2>
                    <p>PET: {{ $user->pet }}</p>
                    <p>BIO: {{ $user->bio }}</p>
                    <button id="follow-btn" class="follow-btn" data-user-id="{{ $user->id }}">フォロー</button>
                    <p id="followers-count"><a href="{{ route('profile.followers', $user->id) }}">フォロワー数: {{ $followersCount }}</a></p>
                    <p id="following-count"><a href="{{ route('profile.following', $user->id) }}">フォロー数: {{ $followingCount }}</a></p>
                    <a href="/chat/{{ $user->id }}">{{ $user->name }}とチャットする</a>
                </div>
                <div class="p-6">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">編集</a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="button-group" style="display: flex; gap: 10px; margin-bottom: 20px;">
                        <button id="show-all-btn" class="btn btn-secondary">すべての投稿を表示</button>
                        <button id="filter-images-btn" class="btn btn-secondary">画像付き投稿のみ表示</button>
                    </div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">ユーザーの投稿</h2>
                    <div class='posts'>
                        @if (is_array($user->posts) || is_object($user->posts))
                            @foreach ($user->posts->sortByDesc('created_at') as $post)
                            <div class='post-card' data-has-image="{{ $post->image_url ? 'true' : 'false' }}">
                                <div class='post-header'>
                                    <a href="{{ route('user.profile', $post->user->id) }}">
                                        <img src="{{ asset($post->user->profile_photo_path) }}" alt="アイコン" class="profile-icon">
                                    </a>
                                    <a href="{{ route('user.profile', $post->user->id) }}" class="user-name">{{ $post->user->name }}</a>
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
                                        <img src="{{ $post->image_url }}" alt="投稿画像" class="post-image" style="max-width: 100%; height: auto;">
                                    @endif
                                    <div class="flexbox">
                                        <i class="fa-solid fa-star like-btn {{ $post->isLikedByAuthUser() ? 'liked' : '' }}" id="{{ $post->id }}"></i>
                                        <p class="count-num">{{ $post->likes->count() }}</p>
                                        <a href="{{ route('posts.comments', $post->id) }}" class="comment-btn">
                                            <i class="fa-regular fa-comment-dots"></i>
                                        </a>
                                        <p class="count-num">{{ $post->comments->count() }}</p>
                                    </div>
                                    <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deletePost({{ $post->id }})">削除</button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const followBtn = document.getElementById('follow-btn');
            const followersCount = document.getElementById('followers-count');
            const followingCount = document.getElementById('following-count');
            const userId = followBtn.getAttribute('data-user-id');

            // 初期状態をサーバーから取得
            fetch(`/is-following/${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.isFollowing) {
                        followBtn.classList.add('following');
                        followBtn.textContent = 'フォロー中';
                    }
                });

            followBtn.addEventListener('click', function() {
                const isFollowing = followBtn.classList.contains('following');
                const url = isFollowing ? `/unfollow/${userId}` : `/follow/${userId}`;
                const method = 'POST';

                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => response.json()).then(data => {
                    if (isFollowing) {
                        followBtn.classList.remove('following');
                        followBtn.textContent = 'フォロー';
                    } else {
                        followBtn.classList.add('following');
                        followBtn.textContent = 'フォロー中';
                    }
                    followersCount.textContent = 'フォロワー数: ' + data.followersCount;
                });
            });

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

            document.getElementById('filter-images-btn').addEventListener('click', function() {
                const posts = document.querySelectorAll('.post-card');
                posts.forEach(post => {
                    if (post.getAttribute('data-has-image') === 'false') {
                        post.style.display = 'none';
                    } else {
                        post.style.display = 'block';
                    }
                });
            });

            document.getElementById('show-all-btn').addEventListener('click', function() {
                const posts = document.querySelectorAll('.post-card');
                posts.forEach(post => {
                    post.style.display = 'block';
                });
            });
        });
    </script>
</x-app-layout>
