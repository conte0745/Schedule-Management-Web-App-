@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar_show_weekly.css') }}">
@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ route('calendar') }}">マンスリー</a>
@endsection
@section('contains')
<chat-component></chat-component>

@endsection