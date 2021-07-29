@extends('layouts.app')

@section('call_css')
<!--<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">-->
@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ url('calendar/') }}">カレンダー</a>
@endsection

@section('contains')
<h1>{{ __('Mypage') }}</h1>

<p>名前の変更</p>


    

@endsection