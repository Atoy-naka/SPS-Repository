<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                コミュニティ一覧
            </h2>
            <a href="{{ route('communities.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                コミュニティ作成
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @foreach ($communities as $community)
                        <div class="mb-4">
                            <h2 class="text-lg font-semibold">{{ $community->name }}</h2>
                            <p>{{ $community->description }}</p>
                            <p>作成日: {{ $community->created_at->format('Y-m-d') }}</p>
                            <a href="{{ route('communities.show', $community) }}" class="text-blue-500 hover:underline">View Community</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
