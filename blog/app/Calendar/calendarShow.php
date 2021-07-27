<?php
namespace App\Calendar;

use Carbon\Carbon;

class calendarShow
{
    private $carbon;

	function __construct($date){
		$this->carbon = new Carbon($date);
	}
	
	public function getdays()
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
	
	public function getmonth()
	{
	    return $this->carbon->format('Y年n月');
	}
	public function geturl()
	{
	    return $this->carbon;
	}
	
}