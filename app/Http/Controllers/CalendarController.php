<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\User;
use App\Models\Weather;
use App\Http\Requests\CalendarRequest;
use App\Calendar\CalendarWeek;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Common\CalendarIndex;


class CalendarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request, Calendar $calendar)
    {
        return CalendarIndex::index($request->all(), $calendar, null);
    }
    
    public function index_move(Request $request, Calendar $calendar, $month)
    {
        if(preg_match('/^(2[0-1][0-9]{2})-(0[1-9]{1}|1[0-2]{1})$/', $month) == 0)
            return redirect('calendar');
            
        return CalendarIndex::index($request->all(), $calendar, $month);
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
        
        return CalendarIndex::store($request, null);
    }
    
    public function update(CalendarRequest $request, $calendar_id)
    {
        return CalendarIndex::store($request, $calendar_id);
    }
    
    public function edit(Calendar $calendar,Request $req)
    {
        $group_id = User::find(Auth::id())->group_id;
        $user = User::find($calendar->find($req->input('calendar_id'))->personal_id)->name;
        
        return view('calendar/edit2')->with(['calendar' => $calendar->find($req->input('calendar_id')),'user' => $user, 'url'=>$req['url']]);
    }

    public function del(Request $request)
    {
        $param = $request->all();
        $calendar = Calendar::find($param['calendar_id'])->delete();
        return redirect($param['url']);
    }
    
}

