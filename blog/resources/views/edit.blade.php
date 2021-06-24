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
        <form action="/posts/{{ $data->id }}" method="post">
            @csrf
            @method('PUT')
    	        <p>タイトル：<br>
        	<input type="text" name="post[title]" value="{{ $data->title }}" placeholder="title" class="@error('post.title') is-invalid @enderror"></p>
    	    @error('post.title')
    	        <div class="alert alert-danger">{{ $message }} </div>
    	    @enderror 
    	        <p>本文：<br>
    	    <textarea name="post[body]" cols="30" rows="5" placeholder="body" class="@error('post.body') is-invalid @enderror">{{ $data->body }}</textarea></p>
    	    @error('post.body')
    	        <div class="alert alert-danger">{{ $message }} </div>
    	    @enderror           
    	    <p><button type="submit" value="add" class="button">update</button></p>
        </form>
        
        <p><a href="/posts">[[return]]</a></p>
    </body>
    </body>
</html>
