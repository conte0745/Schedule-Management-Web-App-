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
<p>状態の変更</p>
<p>色の変更</p>
<p>退会処理</p>

<br>

<p>権限の付与(root)</p>


    

@endsection