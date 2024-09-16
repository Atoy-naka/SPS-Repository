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
                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="rounded-circle" alt="Profile Photo" style="width: 150px; height: 150px; object-fit: cover;">
                    <h2>USER NAME:{{ $user->name }}</h2>
                    <p>PET: {{ $user->pet }}</p>
                    <p>BIO: {{ $user->bio }}</p>
                    <button id="follow-btn" class="follow-btn" data-user-id="{{ $user->id }}">フォロー</button>
                    <p id="followers-count"><a href="{{ route('profile.followers', $user->id) }}">フォロワー数: {{ $followersCount }}</a></p>
                    <p id="following-count"><a href="{{ route('profile.following', $user->id) }}">フォロー数: {{ $followingCount }}</a></p>
                    <a href="/chat/{{ $user->id }}">{{ $user->name }}とチャットする</a>
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
            followingCount.textContent = 'フォロー数: ' + data.followingCount;
        });
    });
});
    </script>
</x-app-layout>
