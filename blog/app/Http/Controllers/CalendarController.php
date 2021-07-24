<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Http\Requests\CalendarRequest;
use App\Calendar\calendarShow;
use App\Calendar\CalendarWeek;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class CalendarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Calendar $calendar)
    {
        $personal_id = Auth::id();
        $group_id = 1;
        
        $query = $calendar->select('calendar_id','date','date_fin','start_time','finish_time')->where('personal_id',$personal_id)->where('group_id',$group_id)->get();

        $calendar = new calendarShow(time());
        
        $url = $calendar->geturl();
        $weeks = $calendar->getdays();
        $month = $calendar->getmonth();
    
        return view('calendar/index')->with(['weeks' => $weeks,'month' => $month,'url' => $url,'query' => $query->toArray()]);
    }
    
    public function index_move(Calendar $calendar, $month)
    {
        $personal_id = Auth::id();
        $group_id = 1;
        
        $query = $calendar->select('calendar_id','date','date_fin','start_time','finish_time')->where('personal_id',$personal_id)->where('group_id',$group_id)->get();
        
        $calendar = new calendarShow($month);
        
        $url = $calendar->geturl();
        $weeks = $calendar->getdays();
        $month = $calendar->getmonth();
        
        //return redirect('/calendar')->with(['weeks' => $weeks,'month' => $month,'query' => $query->toArray()]);
        return view('calendar/index')->with(['weeks' => $weeks,'url' => $url,'month' => $month,'query' => $query->toArray()]);
    }
    
    
    public function show(Calendar $calendar,$counter)
    {
        $group_id = 1;
        
        $query = $calendar->select('personal_id','date','date_fin','start_time','finish_time')->where('group_id',$group_id)->get();
        $query_array = $query->toArray();
        
        $week = new CalendarWeek(time(),$counter);
        $days = $week->getWeekDays();
        $title = $week->getweek();
        
        return view('calendar/show')->with(['days' => $days, 'title' => $title,'works' => $query_array]);
        
    }
    
    public function create($date)
    {
        return view('calendar/create')->with(['date' => $date]);
    }
    
    public function store(CalendarRequest $request, Calendar $calendar)
    {
        $personal_id = Auth::id();
        $group_id = 1;
       
        $input = $request['calendar'];
        $calendar->fill($input);
        $calendar->group_id=$group_id;
        $calendar->personal_id=$personal_id;
        $calendar->save();
        return redirect('/calendar');
        
    }
    
    public function edit(Calendar $calendar,$calendar_id)
    {
        return view('calendar/edit')->with(['calendar' => $calendar->find($calendar_id)]);
    }
    
    
    public function update(CalendarRequest $request, $calendar_id)
    {
        $calendar = Calendar::find($calendar_id);
        $calendar->fill($request['calendar']);
        $calendar->save();
        return redirect('/calendar');
        
    }
    
    public function del($calendar_id)
    {
        Calendar::find($calendar_id)->delete();
        return redirect('/calendar');
    }
    
    public function mypage()
    {
        return view('calendar/mypage');
    }

}

