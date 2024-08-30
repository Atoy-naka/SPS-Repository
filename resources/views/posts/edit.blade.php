<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>編集</title>
    </head>
    <body>
        <h1 class="title">投稿編集画面</h1>
        <form action="/posts/{{ $post->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="content_title">
                <h2>タイトル</h2>
                <input type='text' name='post[title]' value="{{ $post->title }}">
            </div>
            <div class='content__body'>
                <h2>本文</h2>
                <input type='text' name='post[body]' value="{{ $post->body }}">
            </div>
            <input type="submit" value="投稿"/>
        </form>
    </body>
</html>