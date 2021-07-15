@extends('layouts.standard')

@section('contains') 
        <h1>勤務時間の登録</h1>
        <div class="input">
        <form action="/calendar" method="POST">
            @csrf
            <div class="input">
                <label for="date">日付</label>
                <input type="date" value="{{ $date }}" name="calendar[date]"><br>
                @error('calendar.date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <label for="start_time">開始時間</label>
                <input type="time" id="start_time" name="calendar[start_time]" value="{{ old('calendar.start_time') }}"><br>
                    @error('calendar.start_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror   
                <label for="finish_time">終了時間</label>
                <input type="time" id="finish_time" name="calendar[finish_time]" value="{{ old('calendar.finish_time') }}">
                    @error('calendar.finish_time')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    
                    <br>
                <input id="save" type="submit" value="保存">
            </div>
        </form>
        </div>
        
        <p><a href="/calendar">カレンダーに戻る</a></p>
@endsection
