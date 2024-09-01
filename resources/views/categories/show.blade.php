<x-app-layout>
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
        <h1 class="title">
            {{ $post->title }}
        </h1>
        <a href="/categories/{{ $post->category->id }}">{{ $post->category->name }}</a>
        <div class="content">
            <div class="content_post">
                <h3>本文</h3>
                <p>{{ $post->body }}</p>
                <a href="">{{ $post->category->name }}</a>
            </div>
        </div>
        <div class="edit"><a href="/posts/{{ $post->id }}/edit">編集</a></div>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</html>
</x-app-layout>