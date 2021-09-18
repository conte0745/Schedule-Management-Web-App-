@extends('layouts.app')
@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar_create.css') }}">
@endsection
@section('drop-box')
<li class="nav-item">
    <a class="nav-link" href="{{ route('calendar') }}">カレンダー</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('calendar.mypage') }}">{{ __('Mypage') }}</a>
</li>
@endsection
@section('contains') 
<div class="input">
    <div class="card">
        <h1 class="card-title">勤務時間の修正</h1>
        <div class="card-body">
        <form action="{{ route('calendar.update',['calendar_id'=> $calendar['calendar_id'] ]) }}" method="POST">
        @csrf
        @method('PUT')
            <div class="list-group flexible">
                <div class="list-group-item">
                    <label for="date">開始日付</label>
                    <input type="date" value="{{ $calendar['date'] }}" name="calendar[date]"><br>
                    @error('calendar.date')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                            
                    <label for="start_time">開始時間</label>
                    <time-component name="calendar[start_time]" defaulttime="{{ $calendar['start_time'] }}"></time-component>
                    @error('calendar.start_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror 
                </div>
            </div>
            <div class="list-group flexible">
                <div class="list-group-item">
                    <label for="date_fin">開始日付</label>
                    <input type="date" value="{{ $calendar['date_fin'] }}" name="calendar[date_fin]"><br>
                    @error('calendar.date')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="finish_time">終了時間</label>
                    <time-component name="calendar[finish_time]" defaulttime="{{ $calendar['fin_date'] }}"></time-component>
                    @error('calendar.finish_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div><br>
            <div class="save"><input id="save" type="submit" value="保存" class="btn btn-primary"></div>
        </form>
        <div class="delete">
            <form action="{{ route('calendar.del', [ 'calendar_id' =>$calendar['calendar_id']]) }}" method="post" name="form{{ $calendar['calendar_id'] }}">
            @csrf
            @method('delete')
            <div class="delete"><input id="delete" type="submit" value="削除" class="btn btn-danger"></div>
            </form>
        </div>
        </div>
    </div>
</div>
<br>
<p><a href="{{ route('calendar') }}">カレンダーに戻る</a></p>
@endsection
