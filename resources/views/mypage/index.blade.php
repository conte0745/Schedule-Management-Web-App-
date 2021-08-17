@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ route('calendar') }}">カレンダー</a>
@endsection
@section('contains')
<div class="card">
    <div class="card-header"><h1>{{ __('Mypage') }}</h1></div>
    <div class="card-body">
    <div class="card-title"><h2>登録情報</h2></div>
        <div class="list-group">
            <div class="list-group-item">
                <p>名前</p>
                <span>{{ $user['name'] }}</span>
            </div>
            <div class="list-group-item">
                <p>状態</p>
                <span>{{ $user['state'] }}</span>
            </div>
            <div class="list-group-item">
                <p>背景色</p>
                <span style="background-color:{{ $user['color'] }}">{{ $user['color']}}</span>
            </div>
            <div class="list-group-item">
                <a href="{{ route('calendar.mypage.edit') }}">編集</a>
            </div>
            <div class="list-group-item">
                <a href="{{ route('calendar') }}">戻る</a>
            </div>
            @can('isAdmin')
            <div class="list-group-item">
                <a href="{{ route('calendar.root') }}">管理者のページへ</a>
            </div>
            @endcan
        </div>
    </div>
    
</div>
    

@endsection