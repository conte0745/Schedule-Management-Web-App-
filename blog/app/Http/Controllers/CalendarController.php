<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\User;
use App\Http\Requests\CalendarRequest;
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
        
        $firstDay = Carbon::today()->copy()->firstOfMonth()->startOfWeek()->subDay()->format('Y-m-d');
        $lastDay = Carbon::today()->copy()->lastOfMonth()->endOfWeek()->subDay()->format('Y-m-d');
       
        $query = $calendar->select('calendar_id','date','date_fin','start_time','finish_time')->where('personal_id', $personal_id)->where('group_id', $group_id)->whereDate('date','>=', $firstDay)->whereDate('date','<=', $lastDay)->get();
        $query = $query->toArray();

        $calendar = new CalendarWeek(time());
        
        $url = $calendar->getUrl();
        $weeks = $calendar->getMonthDays();
        $title = $calendar->getMonthTitle();
        
        $holidays = \Yasumi\Yasumi::create('Japan', $url->format('Y'), 'ja_JP');
    
        return view('calendar/index')->with(['weeks' => $weeks,'title' => $title,'url' => $url,'query' => $query,'holiday' => $holidays]);
    }
    
    public function index_move(Calendar $calendar, $month)
    {
        if(preg_match('/^(2[0-1][0-9]{2})-(0[1-9]{1}|1[0-2]{1})$/', $month) == 0)
            return redirect('calendar');
            
        $personal_id = Auth::id();
        $group_id = 1;
        
        $firstDay = Carbon::parse($month)->copy()->firstOfMonth()->startOfWeek()->subDay()->format('Y-m-d');
        $lastDay = Carbon::parse($month)->copy()->lastOfMonth()->endOfWeek()->subDay()->format('Y-m-d');
        
        $query = $calendar->select('calendar_id','date','date_fin','start_time','finish_time')->where('personal_id',$personal_id)->where('group_id',$group_id)->whereDate('date','>=', $firstDay)->whereDate('date','<=', $lastDay)->get();
        $query = $query->toArray();
        
        $calendar = new CalendarWeek($month);
        
        $url = $calendar->getUrl();
        $weeks = $calendar->getMonthDays();
        $title = $calendar->getMonthTitle();
        $holidays = \Yasumi\Yasumi::create('Japan', $url->format('Y'), 'ja_JP');
        
        return view('calendar/index')->with(['weeks' => $weeks,'url' => $url,'title' => $title,'query' => $query,'holiday' => $holidays]);
    }
    
    
    public function show(Calendar $calendar, $month, $counter)
    {
        if(preg_match('/^(2[0-1][0-9]{2})-(0[1-9]{1}|1[0-2]{1})$/', $month) == 0)
            return redirect('calendar');

        $week = new CalendarWeek($month,$counter);
        $weeks = $week->getMonthDays();
        
        if($counter < 1 or $counter > count($weeks))
            return redirect('calendar');
        
        $group_id = 1;
        $firstDay = $weeks[$counter-1][0]->format('Y-m-d');
        $lastDay = $weeks[$counter-1][6]->format('Y-m-d');
        
        $query = $calendar->select('calendar_id','personal_id','date','date_fin','start_time','finish_time')->where('group_id',$group_id)->whereDate('date','>=', $firstDay)->whereDate('date','<=', $lastDay)->get();
        $query = $query->toArray();
        
        $volume  = array_column($query, 'date');
        $edition = array_column($query, 'start_time');
        array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $query);
        // https://www.yoheim.net/blog.php?q=20191104 (多次元連想配列のソート)
        
        $tmps = User::select('id','name')->where('group_id',$group_id)->get()->toArray();
        $users = array();
        
        for($i=0;$i<count($tmps);$i++){
            $users[$tmps[$i]['id']] = $tmps[$i]['name'];
        }
    
        $title = $week->getWeekTitle();
        $url = $week->getUrl();
        $days = $week->getWeekDays();
        $holidays = \Yasumi\Yasumi::create('Japan', $url->format('Y'), 'ja_JP');
        
        return view('calendar/show')->with(['days' => $days, 'url' => $url, 'weeks' => $weeks,'title' => $title,'works' => $query,'users' => $users,'id' => Auth::id(),'holiday' => $holidays]);
        
    }
    
    public function create($date)
    {
        return view('calendar/create')->with(['date' => $date]);
    }
    
    public function store(CalendarRequest $request)
    {
        $group_id = 1;
        
        $input = $request['calendar'];
        $startDate = Carbon::parse($input['date']);
        $finishDate = Carbon::parse($input['date_fin']);
        
        for($i=0;$i<$input['loopWeek'];$i++){
            $calendar = new Calendar;
            
            $calendar->date = $startDate->copy()->addWeeks($i)->format('Y-m-d');
            $calendar->date_fin = $finishDate->copy()->addWeeks($i)->format('Y-m-d');
            $calendar->start_time = $input['start_time'];
            $calendar->finish_time = $input['finish_time'];
            $calendar->group_id=$group_id;
            $calendar->personal_id=Auth::id();
            $calendar->save();
        }    
        
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
        return back();
    }
}

