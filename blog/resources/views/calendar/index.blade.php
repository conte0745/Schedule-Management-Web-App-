@extends('layouts.standard')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endsection

@section('contains')

    <h1>Monthly Calendar</h1>
    <div class="calendar_title">{{ $calendar_table->getTitle() }}</div>
    <div class="calendar_show"><p>{!! $calendar_table->render() !!}</p></div>

    

@endsection