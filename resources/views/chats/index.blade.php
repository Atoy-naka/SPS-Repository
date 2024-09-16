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
                        <div class="mb-4 p-4 border rounded-lg">
                            <a href="{{ route('openChat', $chat->id) }}" class="text-lg font-semibold">
                                @if ($chat->owner_id == auth()->id())
                                    {{ $chat->guest->name }}
                                @else
                                    {{ $chat->owner->name }}
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
