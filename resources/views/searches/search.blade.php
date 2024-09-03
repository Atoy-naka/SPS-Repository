<x-app-layout>
    <x-slot name="header">
        　SEARCH
    </x-slot>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>投稿検索</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>投稿一覧</h1>

            <!-- 検索ボックス -->
            <form action="{{ route('search') }}" method="GET">
                <input type="text" name="keyword" placeholder="キーワードを入力">
                <button type="submit">検索</button>
            </form>

            <!-- 検索結果の表示 -->
            @if($posts->isEmpty())
                <p>該当する投稿がありません。</p>
            @else
                <ul>
                    @foreach($posts as $post)
                        <li>
                            <h2>{{ $post->title }}</h2>
                            <p>{{ $post->body }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endsection
    </body>
</html>
</x-app-layout>