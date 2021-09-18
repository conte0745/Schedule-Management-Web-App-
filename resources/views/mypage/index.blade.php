@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

@endsection

@section('contains')
<div class="card">
    <div class="card-header"><h1>{{ __('Mypage') }}</h1></div>
    <div class="card-body">
    <div class="card-title"><h2>登録情報</h2></div>
        @can('isAdmin')
            <div class="list-group-item">
                <a href="{{ route('calendar.root') }}">管理者のページへ</a>
            </div>
        @endcan
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
            <div class="list-group-item">
                <a href="{{ route('calendar.mypage.edit') }}">編集</a>
            </div>
            <div class="list-group-item">
                <a href="{{ route('calendar') }}">戻る</a>
            </div>
            
        </div>
    </div>
    
</div>
    

@endsection