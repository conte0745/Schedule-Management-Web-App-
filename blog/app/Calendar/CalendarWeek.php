<?php
namespace App\Calendar;

use Carbon\Carbon;

class CalendarWeek
{
    private $carbon;

	function __construct($date,$counter)
	{
		$this->carbon = new Carbon($date);
	    $this->counter = substr($counter,4,1) - 1;
	}
	
	private function getMonthDays()
	{
	    $weeks = [];
	    $week = [];
	    
	    $firstDay = $this->carbon->copy()->firstOfMonth();
	    $lastDay = $this->carbon->copy()->lastOfMonth();
	
	    $tmp = $firstDay->copy()->startOfWeek()->subDay();
	    $last = $lastDay->copy()->endOfWeek()->subDay();
	    
	    if($tmp->copy()->addDays(7)->format('j') == '1')
	    {
	    	$tmp->addDays(7);
	    }

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
	    
	    return $weeks;
	}
	
	public function getweek()
	{
	    $MonthDays = $this->getMonthDays();
	    
		if((0 < $this->counter) and ($this->counter < count($MonthDays))){
	    	$WeekDay = $MonthDays[$this->counter];
	    }else{
	    	$WeekDay = $MonthDays[1];
	    }
	    return $WeekDay[0]->format('n/j') . '~' . $WeekDay[6]->format('n/j');
	}
	
	public function getWeekDays()
	{
	    $MonthDays = $this->getMonthDays();
	    //dd((0 < $this->counter) and ($this->counter < count($MonthDays)));
	    
	    if((0 < $this->counter) and ($this->counter < count($MonthDays))){
	    	return $MonthDays[$this->counter];
	    }else{
	    	return $MonthDays[1];
	    }
	}
	
	public function getMonth()
	{
		return $this->getMonthDays();
	}
	
	public function geturl()
	{
	    return $this->carbon;
	}
	
	
}