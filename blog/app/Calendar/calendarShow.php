<?php
namespace App\Calendar;

use Carbon\Carbon;

class calendarShow
{
    private $carbon;

	function __construct($date, $work_datas, $cnt = 0){
		$this->carbon = new Carbon($date);
	    $this->works = $work_datas;
	    $this->cnt = $cnt;
	}
	
	public function getdays()
	{
	    $weeks = [];
	    $week = [];
		
		if($this->cnt == 0)
		{
			$firstDay = $this->carbon->copy()->firstOfMonth();
	    	$lastDay = $this->carbon->copy()->lastOfMonth();
		}
		else if($this->cnt > 0)
		{
			$firstDay = $this->carbon->copy()->addMonthsNoOverflow()->firstOfMonth();
			$lastDay = $this->carbon->copy()->addMonthsNoOverflow()->lastOfMonth();
		}
		else if($this->cnt < 0)
		{
			$firstDay = $this->carbon->copy()->subMonthsNoOverflow()->firstOfMonth();
			$lastDay = $this->carbon->copy()->subMonthsNoOverflow()->lastOfMonth();
		}
		
		
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
	    $weeks[] = $week;
    
	    return $weeks;
	}
	
	public function getmonth()
	{
	    return $this->carbon->addMonths($this->cnt)->format('Y年n月');
	}
}