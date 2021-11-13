@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endsection


@section('contains')

<div class="row container-fluid">
<div class="calendar card col-xl-8 main">
    <div class="nav nav-pills under card-header">
        <span class="title">{{ $carbon->format('Y年n月') }}</span>
        <ul class="nav nav-pills">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"  aria-expanded="False" role="button" id="month" href="">月の移動</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('calendar.index.move', ['month' =>$carbon->copy()->subMonths(1)->format('Y-m')]) }}">前の月({{ $carbon->copy()->subMonths(1)->format('n') }}月)</a>
                    <a class="dropdown-item" href="{{ route('calendar') }}">現在の月</a>
                    <a class="dropdown-item" href="{{ route('calendar.index.move', ['month' =>$carbon->copy()->addMonths(1)->format('Y-m')]) }}">次の月({{ $carbon->copy()->addMonths(1)->format('n') }}月)</a>
                </div>
            </li>
            <li>
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"  aria-expanded="False" id="week" href="">ウィークリー</a>
                <div class="dropdown-menu">
                    @foreach($weeks as $week)
                    <a class="dropdown-item" href="{{ route('calendar.show', ['month' =>$carbon->format('Y-m'),'counter' => $loop->iteration]) }}">第{{ $loop->iteration }}週({{ $weeks[$loop->index][0]->format('n/j') }}~{{$weeks[$loop->index][6]->format('n/j') }})</a>
                    @endforeach
                </div>
            </li>
        </ul>
        </div>
    <table class="card-table table">
        <thead>
            @foreach(['日','月','火','水','木','金','土'] as $day)
                @if($day=='日')
                    <th class="sun">{{ $day }}</th>
                @elseif($day=='土')
                    <th class="sat">{{ $day }}</th>
                @else
                    <th class="every">{{ $day }}</th>
                @endif
            @endforeach
        </thead>
        <tbody>
            @foreach($weeks as $week)
                <tr>
                    @foreach($week as $day)
                        <!--曜日のクラス処理-->
                        @php 
                            $class = 'weekday '; 
                            if($loop->index%7==0)
                                $class = 'sun ';
                            elseif($loop->index%7==6)
                                $class = 'sat ';
                            if($carbon->format('m') != substr($day,5,2))
                                $class = $class . 'blank';
                            if($holiday->isHoliday($day))
                                $class = 'holiday';
                        @endphp
                        
                        <td class="{{ $class }}">
                        
                        <!--日付の入力-->
                        @if(substr($day,8,1) != 0)
                            {{ substr($day,8,2) }}
                        @else
                            {{ substr($day,9,1) }}
                        @endif
                            
                        <div class="create">
                            <a href="{{ route('calendar.create', ['date' => substr($day,0,10),'url'=> $_SERVER["REQUEST_URI"]]) }}">+</a>
                        </div>
                            
            
                        <div class="workTimeZone" style="background-color:{{ $color['color'] }}">
                                    
                        @for($i=0;$i<count($query);$i++)
                            @if($query[$i]['date'] == substr($day,0,10))
                                <div class="workTime">
                                <a href="{{ route('calendar.edit2',['calendar_id' => $query[$i]['calendar_id'],'url'=> $_SERVER["REQUEST_URI"]]) }}">
                                {{ substr($query[$i]['start_time'],0,5) }} ~ {{ substr($query[$i]['finish_time'],0,5) }}
                                    @if($query[$i]['parent_id'] != null) (連) @endif
                                </a>
                                </div>
                            
                                        
                            @endif
                        @endfor
                        </div>  
                        </td>
                    @endforeach
                </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card col-xl-4 info">
    <div class="card-header">work-info</div>
    <div class="card-body">
        <p class="card-title">{{ $start }} ~ {{ $end }} の情報</p>
        <div class="card-text">
            <ul class="ul">
                <li>出勤時間
                    <ul>
                    @php
                    $cnt = 0; $cnt2 = 0; $tmp = 0; $break = 0; 
                    if($search == null ) $search = $query;
                    @endphp
                    @foreach($weeks as $week)
                        @foreach($week as $day)
                            @for($i=0;$i<count($search);$i++)
                                @if($search[$i]['date'] == substr($day,0,10))
                                    <li>
                                        <span>{{ substr($day,0,10) }}</span>
                                        <span class="white">_</span>
                                        <span>{{ substr($search[$i]['start_time'],0,5) }}</span>
                                        <span>~</span>
                                        <span>{{ substr($search[$i]['finish_time'],0,5) }}</span>
                                        <span class="white">_</span>
                                        @php 
                                        $tmp = (strtotime(substr($search[$i]['finish_time'],0,5)) - strtotime(substr($search[$i]['start_time'],0,5)));
                                        $cnt2 += 1; 
                                        $cnt += $tmp;
                                        @endphp
                                        @if($tmp < 21601)
                                            <span>休憩なし</span>
                                        @elseif($tmp > 28800)
                                            <span>休憩60分</span>
                                            @php $break += 3600 @endphp
                                        @else
                                            <span>休憩45分</span>
                                            @php $break += 2700 @endphp
                                        @endif
                                    </li> 
                                @endif
                            @endfor
                        @endforeach
                    @endforeach
                    </ul>
                </li>
                <li>出勤日数
                    <ul><li>{{ $cnt2 }}</li></ul>
                </li>
                <li>勤務時間
                    <ul><li>{{ floor($cnt/3600) }}時間{{ ($cnt/60%60) }}分</li></ul>
                </li>
                <li>実務時間
                    <ul><li>{{ floor(($cnt-$break)/3600) }}時間{{ (($cnt-$break)/60%60) }}分</li></ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="card col-xl-12 search">
    <div class="card-header">Search</div>
    <div class="card-body">
    <div class="card-title"><span>勤務時間の検索</span><span class="text-muted text-sm">結果は右上に表示されます</span></div>
        <form action={{ $_SERVER["REQUEST_URI"] }} method="get" id="search">
            <table>
                <tr>
                    <td><date-component defaultdate="{{ $start }}" name="start" id="start"></date-component></td>
                    <td class="padding">から</td>
                
                    <td><date-component defaultdate="{{ $end }}" name="end" id="end"></date-component></td>
                    <td class="padding">まで</td>
                    <td><input type="submit" form="search" class="btn btn-primary padding" value="Search"></td>
                </tr>
            </table>
                
        </form>
    </div>
</div>
    
</div>
    

@endsection