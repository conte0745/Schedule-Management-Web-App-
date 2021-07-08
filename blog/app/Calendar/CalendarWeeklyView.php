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
	    $week = $weeks[$this->week_counter - 1];
	
		
	    $html[] = '<p class="' . $week->getClassName() . '">';
		$days = $week->getDays();
		$html[] = '</p>';
		    
		foreach($days as $day)
		{
		    $html[] = '<p class="' . $day->getClassName() . '">';
		    $html[] = $day->render(); // day = new CalendarWeekDays;
		    $html[] = '</p>';
		        
		        
		        // 全員の勤務時間を出力
		    for($i=0;$i<count($this->works);$i++)
		    {
		        if($this->works[$i]['date'] == $day->getDate())
		        {
		            $html[] = '<div class="JobTime">user_id::';
		            $html[] = $this->works[$i]['personal_id'] . '  work_time::';
		            $html[] = substr($this->works[$i]['start_time' ], 0, 5) . '~';
		            $html[] = substr($this->works[$i]['finish_time'], 0, 5) . '<br>';
		            $html[] = '</div>';
		        }
		    }
		        
		    $html[] = '</td>';
		        
        }
		    
		$html[] = '</tr>
		';
		
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
	    
	    return $weeks;
	    
	}
	
	/**
	 * タイトル
	 */
	public function getTitle(){
	    
	    $weeks = $this->getWeeks();
	    $week = $weeks[$this->week_counter - 1]->getDays();
	   
	    //var_dump(($week[0]));
	    //var_export(($week[0]));
	    
		return $week[0]->carbon->format('m-d');
	}

	
}
