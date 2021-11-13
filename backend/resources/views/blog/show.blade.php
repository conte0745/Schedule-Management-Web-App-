@extends('layouts.app')

@section('contains') 
        <div class = "border">
            <p class = "h1 text-primary border">{{ $data->title }}</p>
            <p class ="body">{{ $data->body }}</p>
            <p class = "text-muted">更新日 ({{ $data->updated_at }})</p>
        </div>
            <a href="/posts">[[return]]</a>
@endsection