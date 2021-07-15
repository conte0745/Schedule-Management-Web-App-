@extends('layouts.standard')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar_show_weekly.css') }}">

@endsection

@section('contains')
    <h1>Weekly Calendar</h1>
    <div class="calendar_title"><p>{{ $calendar_table->getTitle() }}</p></div>
    <div class="calendar_show"><p>{!! $calendar_table->render() !!}</p></div>


@endsection