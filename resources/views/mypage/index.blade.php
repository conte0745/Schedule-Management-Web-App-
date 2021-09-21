@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

@endsection

@section('contains')
<div class="card main mx-auto">
    <div class="card-header"><span class="h1">{{ __('Mypage') }}</span>
        <!--@can('isAdmin')-->
        <!--    <span class="link">-->
        <!--        <a href="{{ route('calendar.root') }}">　管理者のページへ</a>-->
        <!--    </span>-->
        <!--@endcan-->
    </div>
    <div class="card-body">
    <div class="card-title"><p class="h2">登録情報</p></div>
        <div class="list-group">
            <div class="list-group-item">
                <p>名前</p>
                <span>{{ $user['name'] }}</span>
            </div>
            <div class="list-group-item">
                <p>メールアドレス</p>
                <span>{{ $user['email'] }}</span>
            </div>
            <div class="list-group-item">
                <p>シフトの希望</p>
                <span>{{ $user['state'] }}</span>
            </div>
            <div class="list-group-item">
                <p>背景色</p>
                <span style="background-color:{{ $user['color'] }}">{{ $user['color']}}</span>
            </div>
            <div class="list-group-item">
                <p>LINE notyfy</p>
                @cannot('hasLine')
                <span>連携中</span>
                @endcannot
                @can('hasLine')
                <span>未連携</span>
                @endcan
            </div>
            <a class="list-group-item list-group-item-action list-group-item-primary" href="{{ route('calendar.mypage.edit') }}">編集</a>
            <a class="list-group-item list-group-item-action list-group-item-success" href="{{ route('calendar') }}">戻る</a>
            
            
        </div>
    </div>
    
</div>
    

@endsection