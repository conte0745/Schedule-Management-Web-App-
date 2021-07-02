<?php
namespace App\Calendar;

use Carbon\Carbon;

class CalendarWeeklyView {

	private $carbon;

	function __construct($date,$work_datas,$week_counter){
		$this->carbon = new Carbon($date);
	    $this->works = $work_datas; 
		$week_counter = substr($week_counter,4,1);
		$this->week_counter = (int)$week_counter;
		
	}
	
	
	/**
	 * カレンダーを出力する
	 */
	function render(){
	    $weeks = $this->getWeeks();
	
		foreach($weeks as $week)
		{
		    $html[] = '<tr class="' . $week->getClassName() . '">';
		    $days = $week->getDays();
		    
		    foreach($days as $day)
		    {
		        $html[] = '<td class="' . $day->getClassName() . '">';
		        $html[] = '<a href="/calendar/show/';
		        $html[] = $week->getUrlName(); 
		        $html[] = '">';
		        $html[] = $day->render(); // day = new CalendarWeekDays;
		        $html[] = '</a>';
		        
		        // login_user_idに対する勤務時間を出力
		        for($i=0;$i<count($this->works);$i++)
		        {
		            if($this->works[$i]['date'] == $day->getDate())
		            {
		                $html[] = '<div class="JobTime">';
		                $html[] = substr($this->works[$i]['start_time' ], 0, 5) . '~';
		                $html[] = substr($this->works[$i]['finish_time'], 0, 5) . '<br>';
		                $html[] = '</div>';
		            }
		        }
		        
		        $html[] = '</td>';
		        
		    }
		    
		    $html[] = '</tr>
		    ';
		}
		
		$html[] = '</table>';
		$html[] = '</div>';
		return implode("", $html);
	}
	
	
	protected function getWeeks()
	{
	    $weeks = [];
	    
	    $firstDay = $this->carbon->copy()->firstOfMonth();
	    $lastDay = $this->carbon->copy()->lastOfMonth();
	    
	    $week = new CalendarWeek($firstDay->copy());
	    $weeks[] = $week;
	    
	    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
	    
	    while($tmpDay->lte($lastDay))
	    {
	        $week = new CalendarWeek($tmpDay,count($weeks));
	        $weeks[] = $week;
	        
	        
	        $tmpDay->addDay(7);
	    }
	    //dd($weeks);
	    
	    return $weeks;
	    
	}
	
	/**
	 * タイトル
	 */
	public function getTitle(){
	    $firstDay = $this->carbon->copy()->StartOfWeek()->subDays(1);
	    $lastDay = $this->carbon->copy()->endOfWeek()->subDays(1);
	    $tmp = substr($firstDay,5,6) . ' ~ ' .substr($lastDay,5,6);
		return $tmp;
	}

	
}
