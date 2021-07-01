@extends('layouts.standard')

@section('contains') 
        <h1>新規作成</h1>
        <form action="/posts" method="post">
            @csrf
    	        <p>タイトル：<br>
        	<input type="text" name="post[title]" value="{{ old('post.title') }}" placeholder="title" class="@error('post.title') is-invalid @enderror"></p>
    	    @error('post.title')
    	        <div class="alert alert-danger">{{ $message }} </div>
    	    @enderror 
    	        <p>本文：<br>
    	    <textarea name="post[body]" cols="30" rows="5" placeholder="body" class="@error('post.body') is-invalid @enderror">{{ old('post.body') }}</textarea></p>
    	    @error('post.body')
    	        <div class="alert alert-danger">{{ $message }} </div>
    	    @enderror           
    	    <p><button type="submit" value="add" class="button">save</button></p>
        </form>
        
        <p><a href="/posts">[[return]]</a></p>
@endsection
