<?php

namespace app\Common;

use App\Models\Calendar;
use App\Models\User;
use App\Calendar\CalendarWeek;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarIndex {
    
    public static function index($param, $calendar, $month)
    {
        $personal_id = Auth::id();
        if($month == null){
            $index = new CalendarWeek(time());
            $carbon = new Carbon(time());
        } else {
            $index = new CalendarWeek($month);
            $carbon = new Carbon($month);
        }
        
        $firstDay = $carbon->copy()->firstOfMonth()->startOfWeek()->subDay();
        $lastDay = $carbon->copy()->lastOfMonth()->endOfWeek()->subDay();
        
        if($firstDay->copy()->addDays(7)->format('j') == '1'){
	    	$firstDay->addDays(7);
	    }
	    if($carbon->copy()->lastOfMonth()->format('D') == 'Sun' ){
	    	$lastDay->addDays(7);
	    }
	    
	    $firstDay = $firstDay->format('Y-m-d');
	    $lastDay = $lastDay->format('Y-m-d');
        
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
        
        $carbon = $index->getCarbon();
        $weeks = $index->getMonthDays();
        
        $holidays = \Yasumi\Yasumi::create('Japan', $carbon->format('Y'), 'ja_JP');
        
        return view('calendar/index')->with(['weeks' => $weeks, 'carbon' => $carbon,'query' => $query,'holiday' => $holidays,
                        'search' => $search,'color' =>User::select('color')->find(Auth::id()), 'start' => $start, 'end' => $end]);
    }
    
    public static function store($request, $calendar_id){
        
        $hasId = false;
        $input = $request['calendar'];
        
        if($calendar_id == null){
            $group_id = User::find(Auth::id())->group_id;
            $personal_id = $request['member'];
            $cnt = $input['loopWeek'];
        
            if($personal_id == null) 
                $personal_id = Auth::id();
        } else {
            $calendar = Calendar::find($calendar_id);
            $personal_id = $calendar->personal_id;
            $group_id = $calendar->group_id;
            $cnt = 1;
            $hasId = true;
        }
        
        $startDate = Carbon::parse($input['date']);
        $finishDate = Carbon::parse($input['date_fin']);
        
        for($i=0; $i<$cnt; $i++){
            
            if($startDate->eq($finishDate)) {
                if(!$hasId) $calendar = new Calendar;
                $calendar->date = $startDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar->date_fin = $finishDate->copy()->addWeeks($i)->format('Y-m-d');
                $calendar->start_time = $input['start_time'];
                $calendar->finish_time = $input['finish_time'];
                $calendar->block = round((strtotime($request['calendar.finish_time'])-strtotime($request['calendar.start_time']))/1800);
                $calendar->group_id = $group_id;
                $calendar->personal_id = $personal_id;
                $calendar->save();
                
            } else {
                
                if($hasId == true) {$calendar->forceDelete(); }
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
    
    public static function root($param, $calendar, $month){
        $personal_id = Auth::id();
        $group_id = User::find(Auth::id())->group_id;
        
        $tmps = User::select('id','name')->where('group_id',$group_id)->get()->toArray();
        $users = array();
        
        for($i=0;$i<count($tmps);$i++){
            $users[$tmps[$i]['id']] = [$tmps[$i]['name'], 0, 0];
        }
        
        if($month == null){
            $index = new CalendarWeek(time());
            $carbon = new Carbon(time());
        } else {
            $index = new CalendarWeek($month);
            $carbon = new Carbon($month);
        }
        
        $firstDay = $carbon->copy()->firstOfMonth()->startOfWeek()->subDay();
        $lastDay = $carbon->copy()->lastOfMonth()->endOfWeek()->subDay();
        
        if($firstDay->copy()->addDays(7)->format('j') == '1'){
	    	$firstDay->addDays(7);
	    }
	    if($carbon->copy()->lastOfMonth()->format('D') == 'Sun' ){
	    	$lastDay->addDays(7);
	    }
	    
	    $firstDay = $firstDay->format('Y-m-d');
	    $lastDay = $lastDay->format('Y-m-d');
        
        if($param != null){
            
            $start = $param['start'];
            $end = $param['end'];
            if($start <= $end)
                $search = $calendar->select('personal_id','date','date_fin','start_time','finish_time','parent_id')->where('group_id', $group_id)
                        ->whereDate('date','>=', $start)->whereDate('date','<=', $end)->get()->toArray();
            else
                $search = null;
               
        } else {
            $start = $firstDay;
            $end = $lastDay;
            $search = $calendar->select('personal_id','date','date_fin','start_time','finish_time','parent_id')->where('group_id',$group_id)
                        ->whereDate('date','>=', $firstDay)->whereDate('date','<=', $lastDay)->get()->toArray();
        }
        for($i=0;$i<count($search);$i++){
            $search[$i]['name'] = $users[$search[$i]['personal_id']];
        }
        
        $id = $search[0]['personal_id'];
        $sum = array();
        $cnt = 0;
        for($i=0;$i<count($search);$i++){
            $users[$search[$i]['personal_id']][1] += (strtotime(substr($search[$i]['finish_time'],0,5)) - strtotime(substr($search[$i]['start_time'],0,5)));
            $users[$search[$i]['personal_id']][2] +=1;
        }
       
        $root = (['query' => $search, 'start' => $start, 'end' => $end, 'users' => $users]);
        return $root;
    }
}