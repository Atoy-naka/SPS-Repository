<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>投稿</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>Post</h1>
        <form action="/posts" method="POST">
            @csrf
            <div class="title"></div>
                <h2>タイトル</h2>
                <input type="text" name="post[title]" placeholder="タイトルを入力"/>
            </div>
            <div class="body">
                <h2>本文</h2>
                <textarea name="post[body]" placeholder="本文を入力"></textarea>
            </div>
            <input type="submit" value="投稿"/>
        </form>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</html>