@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar_show_weekly.css') }}">
@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ url('calendar/') }}">マンスリー</a>
@endsection

@section('contains')
<div class="flexible">
    <div class="calendar_title"><h1>{{ $title }}のカレンダー</h1></div>
    <ul class="nav nav-pills  under">
        <li>
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"  aria-expanded="False" id="week" href="">ウィークリー</a>
            <div class="dropdown-menu">
            @foreach($weeks as $week)
            <a class="dropdown-item" href="/calendar/show/{{ $url->format('Y-m') }}/week{{ $loop->iteration }}">第{{ $loop->iteration }}週({{ $weeks[$loop->index][0]->format('n/j') }}~{{$weeks[$loop->index][6]->format('n/j') }})</a>
            @endforeach
            </div>
        </li>
    </ul>
</div>


@foreach($days as $day)
    <div class="card"><div class="card-header">{{ $day->format('n/j') }}</div>
        <div class="card-body">
        @foreach($works as $work)
            @if($work['date'] == $day->format('Y-m-d'))
                <div class="WeekWork"><p>{{ $users[$work['personal_id']] }}::{{ substr($work['start_time'],0,5) }} ~ {{ substr($work['finish_time'],0,5) }}</p></div>
            @endif
        @endforeach
        </div>
    </div>
@endforeach


@endsection