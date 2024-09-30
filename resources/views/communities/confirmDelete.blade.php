<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                コミュニティ削除の確認
            </h2>
            <a href="{{ route('communities.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                コミュニティ一覧に戻る
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3>コミュニティを削除しますか？</h3>
                    <form action="{{ route('communities.delete', $community) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">削除</button>
                        <a href="{{ route('communities.index') }}" class="btn btn-secondary">キャンセル</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
