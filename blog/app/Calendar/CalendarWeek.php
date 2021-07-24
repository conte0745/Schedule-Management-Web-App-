<?php
namespace App\Calendar;

use Carbon\Carbon;

class CalendarWeek
{
    private $carbon;

	function __construct($date,$counter){
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

	    $WeekDay = $MonthDays[$this->counter];
	    
	    return $WeekDay[0]->format('n/j') . '~' . $WeekDay[6]->format('n/j');
	}
	
	public function getWeekDays()
	{
	    $MonthDays = $this->getMonthDays();
	    
	    return $MonthDays[$this->counter];
	}
}