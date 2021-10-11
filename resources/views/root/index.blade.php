@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('contains')

<div class="row container-fluid">
    <div class="card col-xl-6">
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
                    @if(count($users) == 0)
                        <tr><td>データがありません</td></tr>
                    @else
                        @foreach($users as $user)
                            <tr><td>{{ $user['name'] }}</td></tr>
                        @endforeach
                    @endif
                    </table>
                </div>
                
                <a class="list-group-item list-group-item-action list-group-item-primary" href="{{ route('calendar.root.edit') }}">編集</a>
                <a class="list-group-item list-group-item-action list-group-item-success" href="{{ route('calendar') }}">戻る</a>
                
            </div>
        </div>
    </div>
    <div class="card col-xl-6">
        <div class="card-header">work-info : [{{ $root['start'] }} ~ {{ $root['end'] }}]</div>
        <div class="card-body">
            <table class="table table-sm table-borded">
                <tr>
                    <th>クルー</th>
                    <th>シフトの希望</th>
                    <th>勤務時間</th>
                    <th>勤務回数</th>
                </tr>
                @foreach($person as $member)
                    <tr>
                        @if($member['name'] != '不在')
                            <td>{{ $member['name'] }}</td>
                            <td>{{ $member['state'] }}</td>
                            @if($root['users'][$member['id']][1]/60%60 < 10)
                                <td>{{ floor($root['users'][$member['id']][1]/3600) }}:{{ '0'.$root['users'][$member['id']][1]/60%60 }}</td>
                            @else
                                <td>{{ floor($root['users'][$member['id']][1]/3600) }}:{{ $root['users'][$member['id']][1]/60%60 }}</td>
                            @endif
                                <td>{{ $root['users'][$member['id']][2] }}</td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="card col-xl-12 search">
    <span class="card-header">Search</span>
    <div class="card-body">
        <div class="card-title"><span>勤務時間の検索</span></div>
            <form action={{ $_SERVER["REQUEST_URI"] }} method="get" id="search">
                <table>
                    <tr>
                        <td><date-component defaultdate="{{ $root['start'] }}" name="start" id="start"></date-component></td>
                        <td class="padding">から</td>
                    
                        <td><date-component defaultdate="{{ $root['end'] }}" name="end" id="end"></date-component></td>
                        <td class="padding">まで</td>
                        <td><input type="submit" form="search" class="btn btn-primary padding" value="Search"></td>
                    </tr>
                </table>
                    
            </form>
        </div>
    </div>
</div>
    

@endsection