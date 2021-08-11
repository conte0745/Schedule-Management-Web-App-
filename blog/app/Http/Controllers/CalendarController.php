<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\User;
use App\Models\Profiler;
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
        $group_id = User::find($personal_id)->group_id;
        
        $firstDay = Carbon::today()->copy()->firstOfMonth()->startOfWeek()->subDay()->format('Y-m-d');
        $lastDay = Carbon::today()->copy()->lastOfMonth()->endOfWeek()->subDay()->format('Y-m-d');
       
        $query = $calendar->select('calendar_id','date','date_fin','start_time','finish_time')->where('personal_id', $personal_id)->where('group_id', $group_id)->whereDate('date','>=', $firstDay)->whereDate('date','<=', $lastDay)->get();
        $query = $query->toArray();

        $calendar = new CalendarWeek(time());
        
        $url = $calendar->getUrl();
        $weeks = $calendar->getMonthDays();
        $title = $calendar->getMonthTitle();
        
        $holidays = \Yasumi\Yasumi::create('Japan', $url->format('Y'), 'ja_JP');
        
        return view('calendar/index')->with(['weeks' => $weeks,'title' => $title,'url' => $url,'query' => $query,'holiday' => $holidays,'color' =>User::select('color')->find(Auth::id()) ]);
    }
    
    public function index_move(Calendar $calendar, $month)
    {
        if(preg_match('/^(2[0-1][0-9]{2})-(0[1-9]{1}|1[0-2]{1})$/', $month) == 0)
            return redirect('calendar');
            
        $personal_id = Auth::id();
        $group_id = User::find($personal_id)->group_id;
        
        $firstDay = Carbon::parse($month)->copy()->firstOfMonth()->startOfWeek()->subDay()->format('Y-m-d');
        $lastDay = Carbon::parse($month)->copy()->lastOfMonth()->endOfWeek()->subDay()->format('Y-m-d');
        
        $query = $calendar->select('calendar_id','date','date_fin','start_time','finish_time')->where('personal_id',$personal_id)->where('group_id',$group_id)->whereDate('date','>=', $firstDay)->whereDate('date','<=', $lastDay)->get();
        $query = $query->toArray();
        
        $calendar = new CalendarWeek($month);
        
        $url = $calendar->getUrl();
        $weeks = $calendar->getMonthDays();
        $title = $calendar->getMonthTitle();
        $holidays = \Yasumi\Yasumi::create('Japan', $url->format('Y'), 'ja_JP');
        
        return view('calendar/index')->with(['weeks' => $weeks,'url' => $url,'title' => $title,'query' => $query,'holiday' => $holidays,'color' => User::select('color')->find(Auth::id())] );
    }
    
    
    public function show(Calendar $calendar, $month, $counter)
    {
        if(preg_match('/^(2[0-1][0-9]{2})-(0[1-9]{1}|1[0-2]{1})$/', $month) == 0)
            return redirect('calendar');

        $week = new CalendarWeek($month,$counter);
        $weeks = $week->getMonthDays();
        
        if($counter < 1 or $counter > count($weeks))
            return redirect('calendar');
        
        $group_id = User::find(Auth::id())->group_id;
        $firstDay = $weeks[$counter-1][0]->format('Y-m-d');
        $lastDay = $weeks[$counter-1][6]->format('Y-m-d');
        
        $query = $calendar->select('calendar_id','personal_id','date','date_fin','start_time','finish_time','block')->where('group_id',$group_id)->whereDate('date','>=', $firstDay)->whereDate('date','<=', $lastDay)->get();
        $query = $query->toArray();
        
        $volume  = array_column($query, 'date');
        $edition = array_column($query, 'start_time');
        array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $query);
        // https://www.yoheim.net/blog.php?q=20191104 (多次元連想配列のソート)
        
        $tmps = User::select('id','name','color')->where('group_id',$group_id)->get()->toArray();
        $users = array();
        
        for($i=0;$i<count($tmps);$i++){
            $users[$tmps[$i]['id']] = [$tmps[$i]['name'],$tmps[$i]['color']];
        }
        
        $title = $week->getWeekTitle();
        $url = $week->getUrl();
        $days = $week->getWeekDays();
        $holidays = \Yasumi\Yasumi::create('Japan', $url->format('Y'), 'ja_JP');
        
        return view('calendar/show')->with(['days' => $days, 'url' => $url, 'weeks' => $weeks,'title' => $title,'works' => $query,'users' => $users,'id' => Auth::id(),'holiday' => $holidays]);
        
    }
    
    public function create($date)
    {
        $group_id = User::find(Auth::id())->group_id;
        $users = User::select('name','id')->where('group_id',$group_id)->get()->toArray();
        return view('calendar/create')->with(['date' => $date, 'users' => $users, 'own' => User::find(Auth::id())->id]);
    }
    
    public function store(CalendarRequest $request)
    {
        $group_id = User::find(Auth::id())->group_id;
        $personal_id = $request['member'];
    
        $input = $request['calendar'];
        $startDate = Carbon::parse($input['date']);
        $finishDate = Carbon::parse($input['date_fin']);
        
        for($i=0;$i<$input['loopWeek'];$i++){
            
            if($startDate->eq($finishDate))
            {
                $calendar = new Calendar;
                $calendar->date = $startDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar->date_fin = $finishDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar->start_time = $input['start_time'];
                $calendar->finish_time = $input['finish_time'];
                $calendar->block = abs((strtotime($request['calendar.finish_time'])-strtotime($request['calendar.start_time']))/1800);
                $calendar->group_id = $group_id;
                $calendar->personal_id = $personal_id;
                $calendar->save();
            }
            else
            {
                $calendar = new Calendar;
                $calendar->date = $startDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar->date_fin = $finishDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar->start_time = $input['start_time'];
                $calendar->finish_time = '23:59:59';
                $calendar->block = round((strtotime('23:59:59')-strtotime($request['calendar.start_time']))/1800);
                $calendar->group_id = $group_id;
                $calendar->personal_id = $personal_id;
                $calendar->save();   
                
                $calendar = new Calendar;
                $calendar->date = $finishDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar->date_fin = $finishDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar->start_time = '00:00:00';
                $calendar->finish_time = $input['finish_time'];
                $calendar->block = round((strtotime($request['calendar.finish_time'])-strtotime('00:00:00'))/1800);
                $calendar->group_id = $group_id;
                $calendar->personal_id = $personal_id;
                $calendar->save(); 
            }
            
        }    
        
        return redirect('/calendar');
        
    }
    
    public function edit(Calendar $calendar,Request $req)
    {
        return view('calendar/edit')->with(['calendar' => $calendar->find($req->input('calendar_id'))]);
    }
    
    public function edit2(Calendar $calendar,Request $req)
    {
        $group_id = User::find(Auth::id())->group_id;
        $user = User::find($calendar->find($req->input('calendar_id'))->personal_id)->name;
        return view('calendar/edit2')->with(['calendar' => $calendar->find($req->input('calendar_id')),'user' => $user, 'url'=>$req['url']]);
    }
    
    public function update(CalendarRequest $request, $calendar_id)
    {
        $calendar = Calendar::find($calendar_id);
        $calendar->fill($request['calendar']);
        $calendar->block = round((strtotime($request['calendar.finish_time'])-strtotime($request['calendar.start_time']))/1800);
        $calendar->save();
        return redirect('/calendar');
        
    }
   
    
    
    public function del($calendar_id)
    {
        $calendar = Calendar::find($calendar_id)->delete();
        return back();
    }
}

