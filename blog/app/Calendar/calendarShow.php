<?php
namespace App\Calendar;

use Carbon\Carbon;

class calendarShow
{
    private $carbon;

	function __construct($date,$work_datas){
		$this->carbon = new Carbon($date);
	    $this->works = $work_datas;
	}
	
	public function getdays()
	{
	    $weeks = [];
	    $week = [];
	   
	    $firstDay = $this->carbon->copy()->firstOfMonth();
	    $lastDay = $this->carbon->copy()->lastOfMonth();
	    //dd($firstDay->formatLocalized('%Y年%m月%d日(%a)'));
	    $tmp = $firstDay->copy()->startOfWeek()->subDay();
	    $last = $lastDay->copy()->endOfWeek()->subDay();
	    
	    while($tmp->lte($last))
	    {
	       
	        $week[] = $tmp->copy();
	        
	        if(count($week) == 7)
	        {
	            $weeks[] = $week;
	            $week = [];
	        }
	        
	        $tmp->addDay(1);
	        
	    }
	    $weeks[] = $week;
    
	    return $weeks;
	}
	
	public function getmonth()
	{
	    return $this->carbon->format('Y年n月');
	}
}