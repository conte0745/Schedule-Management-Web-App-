@extends('layouts.app')
@section('call_css')
<!--<link rel="stylesheet" href="{{ asset('css/calendar_regist.css') }}">-->
@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ url('calendar/')}}">カレンダー</a>
<a class="dropdown-item card" href="{{ url('calendar/mypage')}}">{{ __('Mypage') }}</a>
@endsection
@section('contains') 
        <h1>勤務時間の修正</h1>
        <div class="input">
        <form action="/calendar" method="POST">
            @csrf
            <div class="input">
                <label for="date">日付</label>
                <input type="date" value="{{ $calendar['date'] }}" name="calendar[date]"><br>
                @error('calendar.date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="start_time">開始時間</label>
                <input type="time" id="start_time" name="calendar[start_time]" value="{{ substr($calendar['start_time'], 0, 5) }}"><br>
                    @error('calendar.start_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror   
                <label for="finish_time">終了時間</label>
                <input type="time" id="finish_time" name="calendar[finish_time]" value="{{ substr($calendar['finish_time'], 0, 5) }}">
                    @error('calendar.finish_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    
                    <br>
                <input id="save" type="submit" value="保存">
            </div>
        </form>
        </div>
        <br>
        <p><a href="/calendar">カレンダーに戻る</a></p>
@endsection
