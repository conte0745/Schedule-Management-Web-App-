<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>simple blog detail</title>

        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    </head>
    <body>
        <h1>{{ $data->title }}</h1>
        <p>{{ $data->body }}</p>
        <h3>更新日</h3>
        <p>{{ $data->updated_at }}</p>
        <a href="/posts">return</a>
        
    </body>
</html>
