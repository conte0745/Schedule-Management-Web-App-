@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endsection


@section('contains')

<div class="row container">
<div class="calendar card col-xl-8">
    <div class="nav nav-pills under card-header">
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
                    <a class="dropdown-item" href="{{ route('calendar.show', ['month' =>$url->format('Y-m'),'counter' => $loop->iteration]) }}">第{{ $loop->iteration }}週({{ $weeks[$loop->index][0]->format('n/j') }}~{{$weeks[$loop->index][6]->format('n/j') }})</a>
                    @endforeach
                </div>
            </li>
        </ul>
    </div>
    
    <table class="table card-body">
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
                        @if($loop->index%7==0)
                            @if(mb_substr($title,5,1) != substr($day,6,1))
                                <td class="sun blank">
                            @else
                                <td class="sun">
                            @endif
                        @elseif($loop->index%7==6)
                            @if(mb_substr($title,5,1) != substr($day,6,1))
                                <td class="sat blank">
                            @else
                                <td class="sat">
                            @endif
                        @else
                            @if(mb_substr($title,5,1) != substr($day,6,1))
                                <td class="weekday blank">
                            @else
                                <td class="weekday">
                            @endif
                        @endif
                        @if($holiday->isHoliday($day))
                            <span class="holiday">
                        @endif
                        <!--日付の入力-->
                        @if(substr($day,8,1) != 0)
                            {{ substr($day,8,2) }}
                        @else
                            {{ substr($day,9,1) }}
                        @endif
                            
                        @if($holiday->isHoliday($day))
                            </span>
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
                                        <!--<div class="delete">-->
                                        <!--    <form action="{{ route('calendar.del', [ 'calendar_id' =>$query[$i]['calendar_id']]) }}" method="post" name="form{{ $query[$i]['calendar_id'] }}">-->
                                        <!--        @csrf-->
                                        <!--        @method('delete')-->
                                        <!--        <input type="hidden" name="delete">-->
                                        <!--        <a href="javascript:form{{ $query[$i]['calendar_id'] }}.submit()" onclick="return confirm('削除しますか?')">-</a>-->
                                                
                                        <!--    </form>-->
                                        <!--</div>-->
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
<div class="card col-xl-4">
    <div class="card-header">work</div>
    <div class="card-body">
        <span class="card-title"></span>
        <div class="card-text">
            <span>今月の勤務時間</span>
        </div>
    </div>
</div>
    
</div>
    

@endsection