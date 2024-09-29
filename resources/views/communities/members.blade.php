<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                メンバー一覧
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
                    <h3>メンバー一覧</h3>
                    <ul>
                        @foreach ($community->users as $user)
                            <li>{{ $user->name }} @if($user->pivot->role == 'leader') (リーダー) @endif</li>
                        @endforeach
                    </ul>
                    @if (auth()->user()->pivot->role == 'leader')
                        <form action="{{ route('communities.leave', $community) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="new_leader_id">新しいリーダーを選択</label>
                                <select name="new_leader_id" id="new_leader_id" required>
                                    @foreach ($community->users as $user)
                                        @if ($user->id != auth()->user()->id)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">退会</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
