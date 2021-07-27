<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\User;
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
        
        if(preg_match('/^(2[0-1][0-9]{2})-(0[1-9]{1}|1[0-2]{1})$/', $month)){
            $calendar = new calendarShow($month);
        }else{
            return redirect('calendar');
        }
            
        
        $url = $calendar->geturl();
        $weeks = $calendar->getdays();
        $month = $calendar->getmonth();
        
        return view('calendar/index')->with(['weeks' => $weeks,'url' => $url,'month' => $month,'query' => $query->toArray()]);
    }
    
    
    public function show(Calendar $calendar, $month, $counter)
    {
        $group_id = 1;
        
        $query = $calendar->select('personal_id','date','date_fin','start_time','finish_time')->where('group_id',$group_id)->get()->toArray();
        
        
        if(preg_match('/^(2[0-1][0-9]{2})-(0[1-9]{1}|1[0-2]{1})$/', $month)){
            $calendar = new calendarShow($month);
        }else{
            return redirect('calendar');
        }
        
        
        
        $tmps = User::select('id','name')->where('group_id',$group_id)->get()->toArray();
        $users = array();
        
        for($i=0;$i<count($tmps);$i++){
            $users[$tmps[$i]['id']] = $tmps[$i]['name'];
        }
    
        
        $week = new CalendarWeek($month,$counter);
        
        $weeks = $week->getMonth();
        $url = $week->geturl();
        $days = $week->getWeekDays();
        $title = $week->getweek();
        
        return view('calendar/show')->with(['days' => $days, 'url' => $url, 'weeks' => $weeks,'title' => $title,'works' => $query,'users' => $users]);
        
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

