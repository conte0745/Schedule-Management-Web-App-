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
            <div class="card">
                <form action="/calendar/update/{{ $calendar['calendar_id'] }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card flexible">
                            <div class="item">
                                <label for="date">開始日付</label>
                                <input type="date" value="{{ $calendar['date'] }}" name="calendar[date]"><br>
                                @error('calendar.date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            
                                <label for="start_time">開始時間</label>
                                <input type="time" id="start_time" name="calendar[start_time]" value="{{ substr($calendar['start_time'], 0, 5) }}"><br>
                                @error('calendar.start_time')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror  
                            </div>
                        </div>
                        <div class="card flexible">
                            <div class="item">
                                <label for="date_fin">開始日付</label>
                                <input type="date" value="{{ $calendar['date_fin'] }}" name="calendar[date_fin]"><br>
                                @error('calendar.date')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            <label for="finish_time">終了時間</label>
                            <input type="time" id="finish_time" name="calendar[finish_time]" value="{{ substr($calendar['finish_time'], 0, 5) }}">
                                @error('calendar.finish_time')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                            
                    <br>
                    
                    <input id="save" type="submit" value="保存" class="btn btn-primary">
                </form>
            </div>
        </div>
        <br>
        <p><a href="/calendar">カレンダーに戻る</a></p>
@endsection
