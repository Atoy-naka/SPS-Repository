<x-app-layout>
    <x-slot name="header">
        投稿の詳細
    </x-slot>
<!DOCTYPE HTML>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>投稿詳細</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <div class="container">
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->body }}</p>
        <div class="footer">
            <a <a href="{{ url()->previous() }}">戻る</a>
        </div>
    </body>
</html>
</x-app-layout>