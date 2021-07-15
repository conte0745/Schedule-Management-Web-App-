@extends('layouts.standard')

@section('call_css')
<link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
@endsection

@section('contains')

    <div class="calendar_title"><h1>{{ $month }}のカレンダー</h1></div>
    
    
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
                                @if($loop->index%7==0)
                                    <td class="sun_date">
                                @elseif($loop->index%7==6)
                                    <td class="sat_date">
                                @else
                                    <td class="every_date">
                                @endif
                                
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
                                        {{ substr($query[$i]['start_time'],0,5) }} ~ {{ substr($query[$i]['finish_time'],0,5) }}
                                        </div>
                                        <div class="delete">
                                            <form action="/calendar/delete/{{ $query[$i]['calendar_id']}}" method="post" name="form">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="calendar_id">
                                                <a href="javascript:form.submit()">-</a>
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