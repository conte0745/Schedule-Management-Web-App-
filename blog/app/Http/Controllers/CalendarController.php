<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Calendar\CalendarView;

class CalendarController extends Controller
{
    public function index(Calendar $calendar_job)
    {
        $personal_id = 9;
        
        $query = $calendar_job->select('date','start_time','finish_time')->where('personal_id',$personal_id)->get();
        $calendar_table = new CalendarView(time(),$query->toArray());
        return view('calendar/index')->with(['calendar_table' => $calendar_table]);
    }
    
    public function create()
    {
        //
    }
}
