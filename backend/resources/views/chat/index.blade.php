@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection

@section('contains')
<div>
    <chat-component auth={{ $auth }}></chat-component>
</div>

@endsection