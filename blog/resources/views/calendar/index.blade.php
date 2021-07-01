@extends('layouts.standard')

@section('call_css')
<link rel="stylesheet" href="css/calendar.css">
@endsection

@section('contains')

    <h1>Calendar</h1>
    
    <!--<input type="date" min="2021-07-01" max="2021-10-01"></input>-->
    <div class="calendar_title" ><p>{{ $calendar_table->getTitle() }}</p></div>
    <div class="calendar_show"><p>{!! $calendar_table->render() !!}</p></div>

    

@endsection