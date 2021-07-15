<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Http\Requests\CalendarRequest;
use App\Calendar\CalendarMonthlyView;
use App\Calendar\CalendarWeeklyView;
use App\Calendar\calendarShow;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Calendar $calendar)
    {
        $personal_id = 1;
        $group_id = 1;
        
        $query = $calendar->select('calendar_id','date','start_time','finish_time')->where('personal_id',$personal_id)->where('group_id',$group_id)->get();
        
        $calendar = new calendarShow(time(),$query->toArray());
        $weeks = $calendar->getdays();
        $month = $calendar->getmonth();
        //dd($weeks);
        return view('calendar/index')->with(['weeks' => $weeks,'month' => $month,'query' => $query->toArray()]);
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
        return view('calendar/create')->with(['date' => $date]);
    }
    
    public function store(CalendarRequest $request, Calendar $calendar)
    {
        $personal_id = 1;
        $group_id = 1;
       
        $input = $request['calendar'];
        $calendar->fill($input);
        $calendar->group_id=$group_id;
        $calendar->personal_id=$personal_id;
        $calendar->save();
        return redirect('/calendar');
        
    }
    
    public function del($calendar_id)
    {
        Calendar::where('calendar_id',$calendar_id)->delete();
        return redirect('/calendar');
    }
    
    public function mypage()
    {
        return view('calendar/mypage');
    }

}

