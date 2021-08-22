@extends('layouts.app')
@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar_create.css') }}">
@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ route('calendar')}}">カレンダー</a>
<a class="dropdown-item card" href="{{ route('calendar.mypage') }}">{{ __('Mypage') }}</a>
@endsection
@section('contains') 
<div class="input">
    <div class="card">
        <div class="card-body">
        <h1 class="card-title">勤務時間の登録</h1>
        <form action="{{ route('calendar')}}" method="POST">
        @csrf
        @can('isAdmin')
            <div class="list-group flexible">
                <div class="list-group-item">
                    <label for="who">登録する人</label>
                    <select name="member" id="who">
                        @foreach($users as $user)
                        @if($own == $user['id'])
                            <option  value="{{ $user['id']}}" selected>{{ $user['name'] }} </option>
                        @else
                            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
        @endcan    
            <div class="list-group flexible">
                <div class="list-group-item">
                    <label for="date">開始日付</label>
                    <input type="date" value="{{ $date }}" name="calendar[date]"><br>
                    @error('calendar.date')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="start_time">開始時間</label>
                    <time-component name="calendar[start_time]" defaulttime="{{ old('calendar.start_time') }}"></time-component>
                    <!--<input type="time" id="start_time" name="calendar[start_time]" value="{{ old('calendar.start_time') }}"><br>-->
                    @error('calendar.start_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror  
                </div>
            </div>
            <div class="list-group flexible">
                <div class="list-group-item">
                    <label for="date_fin">終了日付</label>
                    <input type="date" value="{{ $date }}" name="calendar[date_fin]"><br>
                    @error('calendar.date')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <label for="finish_time">終了時間</label>
                    <time-component name="calendar[finish_time]" defaulttime="{{ old('calendar.finish_time') }}"></time-component>
                    <!--<input type="time" id="finish_time" name="calendar[finish_time]" value="{{ old('calendar.finish_time') }}">-->
                    @error('calendar.finish_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                   
                </div>
            </div>
            <div class="list-group flexible">
                <div class="list-group-item">
                    <label for="loop">繰り返し週数</label>
                    <select name="calendar[loopWeek]" class="form-select">
                        <option value="1" selected>1回</option>
                        <option value="2">2回</option>
                        <option value="3">3回</option>
                        <option value="4">4回</option>
                        <option value="5">5回</option>
                        <option value="6">6回</option>
                    </select>
                </div>
            </div>
            <br>
            <input id="save" type="submit" value="保存" class="btn btn-success">
        </form>
        </div>
    </div>
</div>
<br>
<p><a href="{{ $url }}">カレンダーに戻る</a></p>
@endsection
