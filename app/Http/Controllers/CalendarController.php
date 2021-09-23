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
    
    public function index(Request $request, Calendar $calendar)
    {
        $personal_id = Auth::id();
        $firstDay = Carbon::today()->copy()->firstOfMonth()->startOfWeek()->subDay()->format('Y-m-d');
        $lastDay = Carbon::today()->copy()->lastOfMonth()->endOfWeek()->subDay()->format('Y-m-d');
        
        $param = $request->all();
        
        if(count($param) == 2){
            $start = $param['start'];
            $end = $param['end'];
            if($start <= $end)
                $search = $calendar->select('date','date_fin','start_time','finish_time')->where('personal_id', $personal_id)
                        ->whereDate('date','>=', $start)->whereDate('date','<=', $end)->get()->toArray();
            else
                $search = null;
           
        } else {
            $search = null;
            $start = $firstDay;
            $end = $lastDay;
       
        }
        
        $query = $calendar->select('calendar_id','date','date_fin','start_time','finish_time','parent_id')->where('personal_id', $personal_id)
                        ->whereDate('date','>=', $firstDay)->whereDate('date','<=', $lastDay)->get();
        $query = $query->toArray();

        $calendar = new CalendarWeek(time());
        
        $carbon = $calendar->getCarbon();
        $weeks = $calendar->getMonthDays();
        
        $holidays = \Yasumi\Yasumi::create('Japan', $carbon->format('Y'), 'ja_JP');
        
        return view('calendar/index')->with(['weeks' => $weeks, 'carbon' => $carbon,'query' => $query,'holiday' => $holidays,
                        'search' => $search,'color' =>User::select('color')->find(Auth::id()), 'start' => $start, 'end' => $end]);
    }
    
    public function index_move(Request $request, Calendar $calendar, $month)
    {
        if(preg_match('/^(2[0-1][0-9]{2})-(0[1-9]{1}|1[0-2]{1})$/', $month) == 0)
            return redirect('calendar');
            
        $personal_id = Auth::id();
        $firstDay = Carbon::parse($month)->copy()->firstOfMonth()->startOfWeek()->subDay()->format('Y-m-d');
        $lastDay = Carbon::parse($month)->copy()->lastOfMonth()->endOfWeek()->subDay()->format('Y-m-d');
        
        $param = $request->all();
        if(count($param) == 3){
            $start = $param['start'];
            $end = $param['end'];
            $search = $calendar->select('date','date_fin','start_time','finish_time')->where('personal_id', $personal_id)
                        ->whereDate('date','>=', $start)->whereDate('date','<=', $end)->get()->toArray();
        } else {
            $search = null;
            $start = $firstDay;
            $end = $lastDay;
        }
        
        
        $query = $calendar->select('calendar_id','date','date_fin','start_time','finish_time','parent_id')->where('personal_id',$personal_id)
                        ->whereDate('date','>=', $firstDay)->whereDate('date','<=', $lastDay)->get();
        $query = $query->toArray();
        
        $calendar = new CalendarWeek($month);
        
        $carbon = $calendar->getCarbon();
        $weeks = $calendar->getMonthDays();
        $holidays = \Yasumi\Yasumi::create('Japan', $carbon->format('Y'), 'ja_JP');
        
        return view('calendar/index')->with(['weeks' => $weeks,'carbon' => $carbon,'query' => $query,'holiday' => $holidays,
                             'search' => $search,'color' => User::select('color')->find(Auth::id()), 'start' => $start, 'end' => $end] );
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
        
        $query = $calendar->where('group_id',$group_id)->whereDate('date','>=', $firstDay)->whereDate('date','<=', $lastDay)->get();
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
        $url = $week->getCarbon();
        $days = $week->getWeekDays();
        $holidays = \Yasumi\Yasumi::create('Japan', $url->format('Y'), 'ja_JP');
        
        return view('calendar/show')->with(['days' => $days, 'url' => $url, 'weeks' => $weeks,'title' => $title,'works' => $query,'users' => $users,'id' => Auth::id(),'holiday' => $holidays]);
        
    }
    
    public function create(Request $req)
    {
        $group_id = User::find(Auth::id())->group_id;
        $users = User::select('name','id')->where('group_id',$group_id)->get()->toArray();
        return view('calendar/create')->with(['date' => $req['date'], 'users' => $users, 'own' => User::find(Auth::id())->id,'url'=>$req['url']]);
    }
    
    public function store(CalendarRequest $request)
    {
        $group_id = User::find(Auth::id())->group_id;
        $personal_id = $request['member'];
        if($personal_id == null) $personal_id = Auth::id();
        
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
                $calendar->block = round((strtotime($request['calendar.finish_time'])-strtotime($request['calendar.start_time']))/1800);
                $calendar->group_id = $group_id;
                $calendar->personal_id = $personal_id;
                $calendar->save();
            }
            else
            {
                $calendar = new Calendar;
                $calendar->date = $startDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar->date_fin = $startDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar->start_time = $input['start_time'];
                $calendar->finish_time = '24:00:00';
                $calendar->block = round((strtotime('24:00:00')-strtotime($request['calendar.start_time']))/1800);
                $calendar->group_id = $group_id;
                $calendar->personal_id = $personal_id;
                $calendar->save();   
                
                $id = $calendar->calendar_id;
                
                $calendar2 = new Calendar;
                $calendar2->date = $finishDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar2->date_fin = $finishDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar2->start_time = '00:00:00';
                $calendar2->finish_time = $input['finish_time'];
                $calendar2->block = round((strtotime($request['calendar.finish_time'])-strtotime('00:00:00'))/1800);
                $calendar2->parent_id = $id;
                $calendar2->group_id = $group_id;
                $calendar2->personal_id = $personal_id;
                $calendar2->save(); 
                
                $id2 = $calendar2->calendar_id;
                $calendar->parent_id = $id2;
                $calendar->save();
            }
            
        }    
        
        return redirect($request['url']);
        
    }
    
    // public function edit(Calendar $calendar,Request $req)
    // {
    //     return view('calendar/edit')->with(['calendar' => $calendar->find($req->input('calendar_id'))]);
    // }
    
    public function edit2(Calendar $calendar,Request $req)
    {
        $group_id = User::find(Auth::id())->group_id;
        $user = User::find($calendar->find($req->input('calendar_id'))->personal_id)->name;
        
        return view('calendar/edit2')->with(['calendar' => $calendar->find($req->input('calendar_id')),'user' => $user, 'url'=>$req['url']]);
    }
    
    public function update(CalendarRequest $request, $calendar_id)
    {
        
        $calendar = Calendar::find($calendar_id);
        $group_id = $calendar->group_id;
        $personal_id = $calendar->personal_id;
        
        $input = $request['calendar'];
        $startDate = Carbon::parse($input['date']);
        $finishDate = Carbon::parse($input['date_fin']);
        
        if($startDate->eq($finishDate))
        {
            $calendar->fill($request['calendar']);
            $calendar->block = round((strtotime($request['calendar.finish_time'])-strtotime($request['calendar.start_time']))/1800);
            $calendar->save();
                
        }
        else
        {
            $calendar->delete();
            
            $calendar = new Calendar;
            $calendar->date = $startDate->format('Y-m-d');
            $calendar->date_fin = $startDate->format('Y-m-d');
            $calendar->start_time = $input['start_time'];
            $calendar->finish_time = '24:00:00';
            $calendar->block = round((strtotime('24:00:00')-strtotime($request['calendar.start_time']))/1800);
            $calendar->group_id = $group_id;
            $calendar->personal_id = $personal_id;
            $calendar->save();   
                
            $id = $calendar->calendar_id;
            
            $calendar2 = new Calendar;
            $calendar2->date = $finishDate->format('Y-m-d');
            $calendar2->date_fin = $finishDate->format('Y-m-d');
            $calendar2->start_time = '00:00:00';
            $calendar2->finish_time = $input['finish_time'];
            $calendar2->block = round((strtotime($request['calendar.finish_time'])-strtotime('00:00:00'))/1800);
            $calendar2->parent_id = $id;
            $calendar2->group_id = $group_id;
            $calendar2->personal_id = $personal_id;
            $calendar2->save(); 
                
            $id2 = $calendar2->calendar_id;
            $calendar->parent_id = $id2;
            $calendar->save();
        }
        
        return redirect($request['url']);
        
    }
   
    
    
    public function del(Request $request)
    {
        $param = $request->all();
        $calendar = Calendar::find($param['calendar_id'])->delete();
        return redirect($param['url']);
    }
}

