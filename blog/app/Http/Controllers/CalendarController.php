<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Calendar\CalendarMonthlyView;
use App\Calendar\CalendarWeeklyView;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Calendar $calendar)
    {
        $personal_id = 1;
        $group_id = 1;
        
        $query = $calendar->select('date','start_time','finish_time')->where('personal_id',$personal_id)->where('group_id',$group_id)->get();
        
        $calendar_table = new CalendarMonthlyView(time(),$query->toArray());
        return view('calendar/index')->with(['calendar_table' => $calendar_table]);
    }
    
    public function show(Calendar $calendar,$week_counter)
    {
        $group_id = 1;
        
        $query = $calendar->select('personal_id','date','start_time','finish_time')->where('group_id',$group_id)->get();
        $query_array = $query->toArray();
        
        $calendar_table = new CalendarWeeklyView(time(),$query_array,$week_counter);
        return view('calendar/show')->with(['calendar_table' => $calendar_table]);
        
    }
    
    public function create($date)
    {
        $calendar = new Calendar;
        return view('calendar/create')->with(['calendar' => $calendar, 'date' => $date]);
        
    }
    
    public function mypage()
    {
        return view('calendar/mypage');
    }

}

