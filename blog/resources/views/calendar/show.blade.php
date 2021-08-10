@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar_show_weekly.css') }}">
@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ route('calendar') }}">マンスリー</a>
@endsection

@section('contains')
<div class="flexible">
    <div class="calendar_title"><h1>{{ $title }}のカレンダー</h1></div>
        <ul class="nav nav-pills  under">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"  aria-expanded="False" role="button" id="month" href="">月の移動</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('calendar.index.move', ['month' =>$url->copy()->subMonths(1)->format('Y-m')]) }}">前の月({{ $url->copy()->subMonths(1)->format('n') }}月)</a>
                    <a class="dropdown-item" href="{{ route('calendar.index.move', ['month' =>$url->copy()->addMonths(1)->format('Y-m')]) }}">次の月({{ $url->copy()->addMonths(1)->format('n') }}月)</a>
                    <a class="dropdown-item" href="{{ route('calendar') }}">現在の月</a>
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

<div class="card">
    <div class="card-body">
    @foreach($days as $day)
    
    @if($holiday->isHoliday($day))
        <div class="holiday">
    @endif
    
    @if($loop->index==0)
    <div class="card-title">{{ $day->format('n/j') }}<span class="sun">(日)</span></div>
    @elseif($loop->index==1)
    <div class="card-title">{{ $day->format('n/j') }}(月)</div>
    @elseif($loop->index==2)
    <div class="card-title">{{ $day->format('n/j') }}(火)</div>
    @elseif($loop->index==3)
    <div class="card-title">{{ $day->format('n/j') }}(水)</div>
    @elseif($loop->index==4)
    <div class="card-title">{{ $day->format('n/j') }}(木)</div>
    @elseif($loop->index==5)
    <div class="card-title">{{ $day->format('n/j') }}(金)</div>
    @elseif($loop->index==6)
    <div class="card-title">{{ $day->format('n/j') }}<span class="sat">(土)</span></div>
    @endif
    
    @if($holiday->isHoliday($day))
        </div>
    @endif
    <table class="table table-sm">
        <tr>
        @for($i=0;$i<48;$i++)
            @if($i%6==0)
                <th>{{ $i/2 }}</th>
            @else
                <th></th>
            @endif
        @endfor
        <th>0</th>
        </tr>
        @foreach($works as $work)
        @if($work['date'] == $day->format('Y-m-d'))
        <tr>
            @php $tmp = strtotime('23:30'); $isDisplay = 0; @endphp
            @for($i=0;$i<48-$work['block'];$i++)
                @php
                    $time = date('H:i',strtotime('+30 minute' ,$tmp));
                    $tmp = strtotime($time);
                @endphp
                
            @if((substr($work['start_time'],0,5) <= $time) && $isDisplay == 0)
                @php $isDisplay += 1; @endphp
                <!--colspan edit-->
                <td colspan="{{ $work['block']}}"><div class="flexible" style="background-color:{{ $users[$work['personal_id']][1] }}">{{ $users[$work['personal_id']][0] }}   
                    @if($id == $work['personal_id'])
                            <form action="{{ route('calendar.del',['calendar_id'=> $work['calendar_id']]) }}" method="post" name="form{{ $work['calendar_id'] }}">
                            @csrf
                            @method('delete')
                                <input type="hidden" name="delete">
                                <div class="right"><a href="javascript:form{{ $work['calendar_id'] }}.submit()" onclick="return confirm('削除しますか?')">del</a></div>
                            </form>
                    @endif
                    
                </div><div style="background-color:{{ $users[$work['personal_id']][1] }}">{{ substr($work['start_time'],0,5) }} ~ {{ substr($work['finish_time'],0,5) }}</div></td>
                    
            @else
                <td></td>
            @endif
            @endfor
          
            </tr>
        @endif
        @endforeach
        
    </table>
    @endforeach
    </div>   
</div>

@endsection