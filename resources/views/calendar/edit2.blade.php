@extends('layouts.app')
@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar_create.css') }}">
@endsection

@section('contains') 
<div class="input">
    <div class="card text-center main mx-auto">
        <h1 class="card-header">勤務時間の修正</h1>
            <div class="card-body">
                <div class="list-group flexible">
                    <form action="{{ route('calendar.update',['calendar_id'=> $calendar['calendar_id']]) }}" method="POST" id="regist">
                    @csrf
                    @method('PUT')
                    @can('isAdmin')
                        <div class="list-group-item">
                            <label for="who">登録する人</label>
                            <p class="h4">{{ $user }}</p>
                        </div>
                    @endcan
                    <ul class="list-group-item" style="list-style-type: none">
                        <div class="flexible block">
                            <li>
                                <label for="date">　　開始日付</label>
                                <date-component defaultdate="{{ $calendar['date'] }}" name="calendar[date]" id="date"></date-component>
                            </li>
                        </div>
                        @error('calendar.date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                            
                        <li>
                            <label for="start_time">開始時間</label>
                            <time-component name="calendar[start_time]" defaulttime="{{ $calendar['start_time'] }}"></time-component>
                            @error('calendar.start_time')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror  
                        </li>
                    </ul>
                    <div class="list-group-item">
                        <div class="flexible block">
                            <label for="date_fin">　　終了日付 </label>
                            <date-component defaultdate="{{ $calendar['date_fin'] }}" name="calendar[date_fin]" id="date_fin"></date-component>
                        </div>
                        @error('calendar.date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="finish_time">終了時間</label>
                        <time-component name="calendar[finish_time]" defaulttime="{{ $calendar['finish_time'] }}"></time-component>
                        @error('calendar.finish_time')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
            </div>
            <form action="{{ route('calendar.del', ['calendar_id' =>$calendar['calendar_id'], 'url' => $_SERVER["REQUEST_URI"]]) }}" method="post" name="form{{ $calendar['calendar_id'] }}" id="delete">
                @csrf
                @method('delete')
            </form>
            
            <div class="list-group list-group-horizontal custom">
                <input name="url" value="{{ $url }}" type="hidden" form="regist">
                <input name="url" value="{{ $url }}" type="hidden" form="delete">
                <input id="save" type="submit" value="保存" class="list-group-item list-group-item-action list-group-item-primary save" form="regist">
                <input id="delete" type="submit" value="削除" class="list-group-item list-group-item-action list-group-item-danger delete" 
                    form="delete" onclick="return confirm('削除しますか?')">
            </div>
            <a class="list-group-item list-group-item-action list-group-item-success" href="{{ $url }}">カレンダーに戻る</a>
        </div>
    </div>
    
</div>
@endsection
