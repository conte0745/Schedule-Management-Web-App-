@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ route('calendar') }}">カレンダー</a>
@endsection

@section('contains')
<div class="card">
    <div class="card-header"><h1>管理者メニュー</h1></div>
    <div class="card-body">
    <div class="card-title"><h2>お店の編集</h2></div>
        <div class="list-group">
            <div class="list-group-item">
                <p>お店の名前 (表示用)</p>
                <span>{{ $shop['shop_name'] }}</span>
            </div>
            <div class="list-group-item">
                <p>お店のID (検索用)</p>
                <span>{{ $shop['shop'] }}</span>
            </div>
            <div class="list-group-item">
                <p>作成者</p>
                <table class="table table-sm table-borderless"><tr><td>{{ $one_user[0]['name'] }}</td></tr></table>
            </div>
            <div class="list-group-item">
                <p>共同管理者一覧</p>
                <table class="table table-sm table-borderless">
                @foreach($users as $user)
                    <tr><td>{{ $user['name'] }}</td></tr>
                @endforeach
                </table>
            </div>
            <div class="list-group-item">
                <table class="table table-sm table-borded">
                    <tr><th>クルー一覧</th><th>シフトの希望</th></tr>
                @foreach($members as $member)
                    <tr><td>{{ $member['name'] }}</td><td>{{ $member['state'] }}</td></tr>
                @endforeach
                </table>
            </div>
            <div class="list-group-item">
                <a href="{{ route('calendar.root.edit') }}">編集</a>
            </div>
            <div class="list-group-item">
                <a href="{{ route('calendar.mypage') }}">マイページへ戻る</a>
            </div>
        </div>
    </div>
</div>

@endsection