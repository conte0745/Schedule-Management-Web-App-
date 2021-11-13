@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar_show_weekly.css') }}">
@endsection

@section('contains')
<div class="nav nav-pills under">
    <div class="title">{{ $title }}</div>
        <ul class="nav nav-pills">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"  aria-expanded="False" role="button" id="month" href="">月の移動</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('calendar.index.move', ['month' =>$url->copy()->subMonths(1)->format('Y-m')]) }}">前の月({{ $url->copy()->subMonths(1)->format('n') }}月)</a>
                    <a class="dropdown-item" href="{{ route('calendar') }}">現在の月</a>
                    <a class="dropdown-item" href="{{ route('calendar.index.move', ['month' =>$url->copy()->addMonths(1)->format('Y-m')]) }}">次の月({{ $url->copy()->addMonths(1)->format('n') }}月)</a>
                </div>
            </li>
            <li>
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"  aria-expanded="False" id="week" href="">ウィークリー</a>
                <div class="dropdown-menu">
                    @foreach($weeks as $week)
                    <a class="dropdown-item" href="{{ route('calendar.show',['month' =>$url->format('Y-m'),'counter' => $loop->iteration]) }}">第{{ $loop->iteration }}週({{ $weeks[$loop->index][0]->format('n/j') }}~{{$weeks[$loop->index][6]->format('n/j') }})</a>
                    @endforeach
                </div>
            </li>
        </ul>
</div>
<table class="table table-sm table-bordered">
@foreach($days as $day)
<td><a href="#index{{ $loop->index }}">{{ $day->format('n/j') }}</a></td>
@endforeach
</table>

<div class="card calendar">
    <div class="card-body">
    @foreach($days as $day)
    
    @if($holiday->isHoliday($day))
        <div class="holiday">
    @endif
    
    @if($loop->index==0)
    <div class="card-title"><a id="index0">{{ $day->format('n/j') }}<span class="sun">(日)</span></a><a href="{{ route('calendar.create', ['date' => substr($day,0,10),'url'=> $_SERVER["REQUEST_URI"]]) }}"> 新規作成</a></div>
    @elseif($loop->index==1)
    <div class="card-title"><a id="index1">{{ $day->format('n/j') }}(月)</a><a href="{{ route('calendar.create', ['date' => substr($day,0,10), 'url'=> $_SERVER["REQUEST_URI"]]) }}"> 新規作成</a></div>
    @elseif($loop->index==2)
    <div class="card-title"><a id="index2">{{ $day->format('n/j') }}(火)</a><a href="{{ route('calendar.create', ['date' => substr($day,0,10), 'url'=> $_SERVER["REQUEST_URI"]]) }}"> 新規作成</a></div>
    @elseif($loop->index==3)
    <div class="card-title"><a id="index3">{{ $day->format('n/j') }}(水)</a><a href="{{ route('calendar.create', ['date' => substr($day,0,10), 'url'=> $_SERVER["REQUEST_URI"]]) }}"> 新規作成</a></div>
    @elseif($loop->index==4)
    <div class="card-title"><a id="index4">{{ $day->format('n/j') }}(木)</a><a href="{{ route('calendar.create', ['date' => substr($day,0,10), 'url'=> $_SERVER["REQUEST_URI"]]) }}"> 新規作成</a></div>
    @elseif($loop->index==5)
    <div class="card-title"><a id="index5">{{ $day->format('n/j') }}(金)</a><a href="{{ route('calendar.create', ['date' => substr($day,0,10), 'url'=> $_SERVER["REQUEST_URI"]]) }}"> 新規作成</a></div>
    @elseif($loop->index==6)
    <div class="card-title"><a id="index6">{{ $day->format('n/j') }}<span class="sat">(土)</span></a><a href="{{ route('calendar.create', ['date' => substr($day,0,10),'url'=> $_SERVER["REQUEST_URI"]]) }}"> 新規作成</a></div>
    @endif
    
    @if($holiday->isHoliday($day))
        </div>
    @endif
    <div class="table-responsive-md">
    <table class="table table-sm ">
        <thead border="1">
            <tr>
            @for($i=0;$i<48;$i++)
                @if($i%6==0)
                    <th colspan="6">{{ $i/2 }}</th>
                    
                @endif
            @endfor
            </tr>
        </thead>
        <tbody>
        @foreach($works as $work)
        @if($work['date'] == $day->format('Y-m-d'))
        <tr>
            @php $tmp = strtotime('23:31'); $isDisplay = 0; @endphp
            @for($i=0;$i<49-$work['block'];$i++)
                @php
                    $time = date('H:i',strtotime('+30 minute' ,$tmp));
                    $tmp = strtotime($time);
                @endphp
                
            @if((substr($work['start_time'],0,5) <= $time) && $isDisplay == 0)
                @php $isDisplay += 1; @endphp
                <!--colspan edit-->
                <td colspan="{{ $work['block']}}" style="background-color:{{ $users[$work['personal_id']][1] }}">
                    <span class="name">{{ $users[$work['personal_id']][0] }}</span>
                    <span class="time">{{ substr($work['start_time'],0,5) }} ~ {{ substr($work['finish_time'],0,5) }}</span>
                    
                    @can('isOwn',$work['personal_id'])
                        <form action="{{ route('calendar.del',['calendar_id'=> $work['calendar_id']]) }}" method="post" name="form{{ $work['calendar_id'] }}" id="delete">
                        @csrf
                        @method('delete')
                        </form>
                    <div class="flexible">
                        <input name="url" type="hidden" value="{{ $_SERVER["REQUEST_URI"] }}" form="delete">
                        <a href="javascript:form{{ $work['calendar_id'] }}.submit()" onclick="return confirm('削除しますか?')" class="btn btn-sm btn-light del" form="delete">削除</a>
                        <a href="{{ route('calendar.edit2',['calendar_id'=> $work['calendar_id'],'url'=> $_SERVER["REQUEST_URI"]]) }}" class="btn btn-sm btn-light edit">編集</a>
                    </div>
                    @endcan
            
                    
                </td>
                    
            @else
                <td></td>
            @endif
            @endfor
        </tr>
        </tbody>
        @endif
        @endforeach
    </table>
    </div>   
    @endforeach
    
    </div>   
</div>

@endsection