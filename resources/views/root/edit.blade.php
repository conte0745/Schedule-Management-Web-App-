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
        <form action="{{ route('calendar.root.update',['id'=>$shop['id']]) }}" method="post" class="list-group">
        @csrf
        @method('put')
            <div class="list-group-item">
                <label for="edit_name">お店の名前 (表示用)</label><br>
                <input type="text" value="{{ $shop['shop_name'] }}" name="edit_name" id="edit_name" class="@error('edit_name') is-invalid @enderror">
                @error('edit_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="list-group-item">
                <label for="edit_shop">お店のID (検索用)</label><br>
                <input type="text" value="{{ $shop['shop'] }}" name="edit_shop" id="edit_shop" class="@error('edit_shop') is-invalid @enderror">
                @error('edit_shop')
                        <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="list-group-item">
                <p>共同管理者の一覧</p>
                @foreach($users as $user)
                    <span>({{ $user['name'] }}) </span>
                @endforeach
                <br><label for="root">共同管理者の追加</label><br>
                <select name="shop[add_root]">
                    <option value="none" selected>設定しない</option>
                @foreach($members as $member)
                    <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
                @endforeach
                </select>
            </div>
            <div class="list-group-item">
                <label for="no_root">共同管理者の削除</label><br>
                <select name="shop[del_root]">
                    <option value="none" selected>設定しない</option>
                @foreach($users as $user)
                    <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                @endforeach
                </select>
            </div>
            
            <div class="list-group-item">
                <input id="save" type="submit" value="保存" class="btn btn-primary">
            </div>
            <div class="list-group-item" >
                <a href="{{ route('calendar.root' )}}">保存せずに戻る</a>
            </div>
        </form>
    </div>
</div>

@endsection