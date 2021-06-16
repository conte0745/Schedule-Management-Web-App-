<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>simple blog detail</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    </head>
    <body style = "background-color:#fffafa">
        <div class = "border">
            <p class = "h1 text-primary">{{ $data->title }}</p>
            <p class ="border">{{ $data->body }}</p>
            <p class = "h4 ">更新日</p>
            <p>{{ $data->updated_at }}</p>
            <a href="/posts">return</a>
        </div>
    </body>
</html>
