@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ route('calendar') }}">カレンダー</a>
@endsection

@section('contains')
<div class="card">
    <div class="card-header"><span class="h1">管理者メニュー</span></div>
    <div class="card-body">
        <div class="card-title h2">店舗情報</div>
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
                <span>作成者</span>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td>{{ $one_user[0]['name'] }}</td>
                    </tr>
                </table>
            </div>
            <div class="list-group-item">
                <span>共同管理者一覧</span>
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
            <a class="list-group-item list-group-item-action list-group-item-primary" href="{{ route('calendar.root.edit') }}">編集</a>
            <a class="list-group-item list-group-item-action list-group-item-success" href="{{ route('calendar.mypage') }}">マイページへ戻る</a>
            
        </div>
    </div>
</div>

@endsection