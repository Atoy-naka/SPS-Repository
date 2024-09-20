<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-4">チャット一覧</h2>
                    @foreach ($chats as $chat)
                        @php
                            $latestMessage = $chat->messages()->latest()->first();
                        @endphp
                        <div class="mb-4 p-4 border rounded-lg flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="{{ asset('storage/' . ($chat->owner_id == auth()->id() ? $chat->guest->profile_photo_path : $chat->owner->profile_photo_path)) }}" class="rounded-circle" alt="Profile Photo" style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                <div class="flex-grow">
                                    <div class="text-sm text-gray-500">
                                        {{ $chat->owner_id == auth()->id() ? $chat->guest->name : $chat->owner->name }}
                                    </div>
                                    @if ($latestMessage)
                                        <div class="text-lg font-semibold">
                                            <a href="{{ route('openChat', ($chat->owner_id == auth()->id() ? $chat->guest->id : $chat->owner->id)) }}">
                                                {{ $latestMessage->user_id == auth()->id() ? 'あなた' : $latestMessage->user->name }}: {{ $latestMessage->body }}
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-400 text-right">
                                            {{ $latestMessage->created_at->format('Y-m-d H:i') }}
                                            @if ($latestMessage->is_read)
                                                <span class="read-status">既読</span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-lg font-semibold">
                                            <a href="{{ route('openChat', $chat->id) }}">
                                                メッセージがありません
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <form action="{{ route('chat.destroy', $chat->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');" style="position: relative; z-index: 10;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-white bg-red-700 px-5 py-2 ml-4" style="position: relative; z-index: 20;">削除</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

