@extends('layouts.app')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endsection
@section('drop-box')
<a class="dropdown-item card" href="{{ url('calendar/mypage')}}">{{ __('Mypage') }}</a>
@endsection

@section('contains')
    <div class="flexible">
        <div class="calendar_title"><h1>{{ $month }}のカレンダー</h1></div>
        <ul class="nav nav-pills  under">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"  aria-expanded="False" role="button" id="month" href="">月の移動</a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/calendar/move/{{ $url->copy()->subMonths(1)->format('Y-m') }}">前の月</a>
                    <a class="dropdown-item" href="/calendar/move/{{ $url->copy()->addMonths(1)->format('Y-m') }}">次の月</a>
                    <a class="dropdown-item" href="/calendar">現在の月</a>
                </div>
            </li>
            <li>
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"  aria-expanded="False" id="week" href="">ウィークリー</a>
                <div class="dropdown-menu">
                    @foreach($weeks as $week)
                    <a class="dropdown-item" href="/calendar/week{{ $loop->iteration }}">第{{ $loop->iteration }}週({{ $weeks[$loop->index][0]->format('n/j') }}~{{$weeks[$loop->index][6]->format('n/j') }})</a>
                    @endforeach
                </div>
            </li>
        </ul>
    </div>
    
    <div class="calendar_show">
        <table class="table">
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
                            @if(mb_substr($month,5,1) != substr($day,6,1))
                                <div class="blank">
                            @endif
                            <div class="url">
                                <!--曜日のクラス処理-->
                                @if($loop->index%7==0)
                                    <td class="sun">
                                @elseif($loop->index%7==6)
                                    <td class="sat">
                                @else
                                    <td class="weekday">
                                @endif
                                <!--日付の入力-->
                                @if(substr($day,8,1) != 0)
                                    {{ substr($day,8,2) }}
                                @else
                                    {{ substr($day,9,1) }}
                                @endif
                                
                                <div class="create">
                                    <a href="/calendar/create/{{ substr($day,0,10) }}">+</a>
                                </div>
                            </div>
                            
                            <div class="workTimeZone">
                                @for($i=0;$i<count($query);$i++)
                                    @if($query[$i]['date'] == substr($day,0,10))
                                        <div class="workTime">
                                            @if($query[$i]['date_fin'] != substr($day,0,10))
                                            <a href="/calendar/edit/{{ $query[$i]['calendar_id'] }}">
                                                {{ substr($query[$i]['start_time'],0,5) }} ~ (翌){{ substr($query[$i]['finish_time'],0,5) }}
                                            </a>
                                            @else
                                            <a href="/calendar/edit/{{ $query[$i]['calendar_id'] }}">
                                                {{ substr($query[$i]['start_time'],0,5) }} ~ {{ substr($query[$i]['finish_time'],0,5) }}
                                            </a>
                                            @endif
                                        </div>
                                        <div class="delete">
                                            <form action="/calendar/delete/{{ $query[$i]['calendar_id']}}" method="post" name="form{{ $query[$i]['calendar_id'] }}">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="delete">
                                                <a href="javascript:form{{ $query[$i]['calendar_id'] }}.submit()" onclick="return confirm('削除しますか?')">-</a>
                                                <!--//https://qiita.com/next1ka2u/items/9736ce2f9c7f3aa69d61-->
                                            </form>
                                        </div>
                                    @endif
                                @endfor
                            </div>        
                            </td>
                                
                            @if(mb_substr($month,5,1) != substr($day,6,1))
                                </div>
                            @endif
                            
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    

@endsection