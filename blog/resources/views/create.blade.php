<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="description" content="simple_blog" />
        <title>blog_create</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    </head>
    
    <body style="background-color:#fffafa">
        <h1>新規作成</h1>
        <form action="/posts" method="post">
            @csrf
    	        <p>タイトル：<br>
        	<input type="text" name="title" value="{{ old('title') }}" placeholder="title" class="@error('title') is-invalid @enderror"></p>
    	    @error('title')
    	        <div class="alert alert-danger">{{ $message }} </div>
    	    @enderror 
    	        <p>本文：<br>
    	    <textarea name="body" cols="30" rows="5" placeholder="body" class="@error('body') is-invalid @enderror">{{ old('body') }}</textarea></p>
    	    @error('body')
    	        <div class="alert alert-danger">{{ $message }} </div>
    	    @enderror           
    	    <p><button type="submit" value="add" class="button">save</button></p>
        </form>
        
        <p><a href="/posts">[[return]]</a></p>
    </body>
    
</html>
