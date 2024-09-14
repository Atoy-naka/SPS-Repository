<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Following') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @foreach ($following as $followed)
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between relative">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $followed->profile_photo_path) }}" class="rounded-circle" alt="Profile Photo" style="width: 50px; height: 50px; object-fit: cover;">
                            <div class="ml-4">
                                <a href="{{ route('user.profile', $followed->id) }}" class="text-lg font-semibold">{{ $followed->name }}</a>
                                <p>{{ $followed->bio }}</p>
                            </div>
                        </div>
                        <button id="follow-btn-{{ $followed->id }}" class="follow-btn" data-user-id="{{ $followed->id }}">フォロー</button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const followButtons = document.querySelectorAll('.follow-btn');

    followButtons.forEach(button => {
        const userId = button.getAttribute('data-user-id');

        // 初期状態をサーバーから取得
        fetch(`/is-following/${userId}`)
            .then(response => response.json())
            .then(data => {
                if (data.isFollowing) {
                    button.classList.add('following');
                    button.textContent = 'フォロー中';
                }
            });

        button.addEventListener('click', function() {
            const isFollowing = button.classList.contains('following');
            const url = isFollowing ? `/unfollow/${userId}` : `/follow/${userId}`;
            const method = 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => response.json()).then(data => {
                if (isFollowing) {
                    button.classList.remove('following');
                    button.textContent = 'フォロー';
                } else {
                    button.classList.add('following');
                    button.textContent = 'フォロー中';
                }
            });
        });
    });
});
</script>
</x-app-layout>
