@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar_show_weekly.css') }}">
@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ url('calendar/') }}">カレンダー</a>
@endsection

@section('contains')

<h1>{{ $title }} のカレンダー</h1>

@foreach($days as $day)
    <div class="card"><div class="card">{{ $day->format('n/j') }}</div>
    @foreach($works as $work)
        @if($work['date'] == $day->format('Y-m-d'))
            <div class="WeekWork"><p>{{ $work['personal_id'] }}::{{ substr($work['start_time'],0,5) }} ~ {{ substr($work['finish_time'],0,5) }}</p></div>
        @endif
    </div>
    @endforeach
@endforeach


@endsection