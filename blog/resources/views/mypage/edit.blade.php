@extends('layouts.app')

@section('call_css')
<!--<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">-->
@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ route('calendar') }}">カレンダー</a>
@endsection

@section('contains')
<div class="card">
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
                <label for="state">状態(現在：{{ $user['state'] }})</label><br>
                <select name="user[state]" id="state">
                    <option value="state1">state1</option>
                    <option value="state2">state2</option>
                    <option value="state3">state3</option>
                    <option value="state4">state4</option>
                </select>
            </div>
            <div class="list-group-item">
                <label for="color">背景色 (デフォルト値：#fff8dc)</label><br>
                <input type="color" name="user[color]" id="user[color]" value="{{ $user['color'] }}" id="color"><br>
                <span style="background-color:{{ $user['color'] }}">現在のカラーコード({{ $user['color']}})</span>
            </div>
            <div class="list-group-item">
                <input id="save" type="submit" value="保存" class="btn btn-primary">
            </div>
        </form>
            <div class="list-group-item" >
                <a href="{{ route('calendar.mypage' )}}">保存せずに戻る</a>
            </div>
    </div>
</div>
<br>

<p>権限の付与(root)</p>


@endsection