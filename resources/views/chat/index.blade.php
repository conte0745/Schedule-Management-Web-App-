@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection

@section('contains')

<div class="chat1">
    <chat-component auth={{ $auth }}></chat-component>
</div>

@endsection