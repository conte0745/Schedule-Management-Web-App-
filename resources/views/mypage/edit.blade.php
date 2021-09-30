@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection


@section('contains')
<div class="card main mx-auto">
    <div class="card-header">
        <h1>{{ __('Mypage') }}</h1>
    </div>
    <div class="card-body">
        <div class="card-title"><h2>登録情報の編集</h2></div>
        <form action="{{ route('calendar.mypage.update') }}" method="post" class="list-group">
        @csrf
        @method('PUT')
            <div class="list-group-item">
                <label for="name">名前</label><br>
                <input type="text" value="{{ $user['name'] }}" name="user[name]" id="name">
                @error('user.name')
                        <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="list-group-item">
                <label for="state">シフトの希望 (現在：{{ $user['state'] }})</label><br>
                <select name="user[state]" id="state">
                    <option value="設定しない" selected>設定しない</option>
                    <option value="もっとシフトに入りたい">もっとシフトに入りたい</option>
                    <option value="もうちょっとシフトをへらしたい">もうちょっとシフトをへらしたい</option>
                    <option value="現状維持">現状維持</option>
                </select>
            </div>
            <div class="list-group-item">
                <label for="color">背景色 (デフォルト値：#fff8dc)</label><br>
                <input type="color" name="user[color]" id="user[color]" value="{{ $user['color'] }}" id="color"><br>
                <span style="background-color:{{ $user['color'] }}">現在のカラーコード({{ $user['color']}})</span>
            </div>
            
            <input class="list-group-item list-group-item-action list-group-item-primary" id="save" type="submit" value="保存" class="btn btn-primary">
            
        </form>
        @if($user['line'] == null)
            <!--<a class="list-group-item list-group-item-action list-group-item-warning" href="{{ route('calendar.line.register') }}">LINEと連携する(β)</a>-->
        @else
            <a class="list-group-item list-group-item-action list-group-item-warning" href="{{ route('calendar.line.lift') }}">lineと連携を解除</a>
        @endif
        <a class="list-group-item list-group-item-action list-group-item-success" href="{{ route('calendar.mypage' )}}">保存せずに戻る</a>
            
    </div>
</div>

@endsection