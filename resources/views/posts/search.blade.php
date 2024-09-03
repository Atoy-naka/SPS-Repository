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
    <div class="container">
        <!-- 検索ボックス -->
        <form action="{{ route('search') }}" method="GET">
            <input type="text" name="keyword" placeholder="キーワードを入力" value="{{ request()->input('keyword') }}"/>
            <button type="submit">[検索]</button>
        </form>

        <!-- 検索結果の表示 -->
        @if(request()->has('keyword'))
            @if($posts->isEmpty())
                <p>該当する投稿がありません。</p>
            @else
                <ul>
                    @foreach($posts as $post)
                        <li>
                            <!-- 投稿のタイトルをリンクにする -->
                            タイトル：<h2><a href="{{ route('searchshow', ['post' => $post->id]) }}">{{ $post->title }}</a></h2>
                            本文：<p>{{ $post->body }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endif
    </div>
    </body>
</html>
</x-app-layout>