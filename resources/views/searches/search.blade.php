<x-app-layout>
    <x-slot name="header">
        <h2>SEARCH</h2>
    </x-slot>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>投稿検索</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                background-color: #f8fafc;
                color: #333;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }
            form {
                display: flex;
                justify-content: center;
                margin-bottom: 20px;
            }
            input[type="text"] {
                width: 70%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                margin-right: 10px;
            }
            button {
                padding: 10px 20px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            button:hover {
                background-color: #0056b3;
            }
            ul {
                list-style-type: none;
                padding: 0;
            }
            li {
                margin-bottom: 20px;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                background-color: #f9f9f9;
            }
            h2 {
                margin: 0;
                font-size: 1.5em;
                color: #007bff;
            }
            p {
                margin: 10px 0 0;
            }
        </style>
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
