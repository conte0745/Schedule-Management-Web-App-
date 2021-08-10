@extends('layouts.app')

@section('call_css')

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
                <span> </span>
                <p>共同管理者一覧</p>
                @foreach($users as $user)
                    <span>{{ $user['name'] }}</span>
                @endforeach
            </div>
            <div class="list-group-item">
                <p>メンバー一覧</p>
                @foreach($members as $member)
                    <span>{{ $member['name'] }}</span>
                @endforeach
            </div>
            <div class="list-group-item">
                <a href="{{ route('calendar.root.edit') }}">編集</a>
            </div>
        </div>
    </div>
</div>

@endsection