<?php
namespace App\Calendar;

use Carbon\Carbon;

class CalendarMonthlyView {

	private $carbon;

	function __construct($date,$work_datas){
		$this->carbon = new Carbon($date);
	    $this->works = $work_datas; 
	
	}
	
	
	/**
	 * タイトル
	 */
	public function getTitle(){
		return $this->carbon->format('Y年n月');
	}

	/**
	 * カレンダーを出力する
	 */
	function render(){
		$html = [];
		$html[] = '<div class="calendar">';
		$html[] = '<table class="table">';
		$html[] = '<thead>';
		$html[] = '<tr>';
        $html[] = '<th class="sun">日</th>';
		$html[] = '<th>月</th>';
		$html[] = '<th>火</th>';
		$html[] = '<th>水</th>';
		$html[] = '<th>木</th>';
		$html[] = '<th>金</th>';
		$html[] = '<th class="sat">土</th>';
		$html[] = '</tr>';
		$html[] = '</thead>';
		
		
		$weeks = $this->getWeeks();
	
		foreach($weeks as $week)
		{
		    $html[] = '<tr class="' . $week->getClassName() . '">';
		    $days = $week->getDays();
		    
		    foreach($days as $day)
		    {
		        $html[] = '<td class="' . $day->getClassName() . '">';
		        $html[] = '<div class="url"><div class="url1">';
		        $html[] = '<a href="/calendar/show/';
		        $html[] = $week->getUrlName(); 
		        $html[] = '">';
		        $html[] = $day->render(); // day = new CalendarWeekDays;
		        $html[] = '</a>';
		        $html[] = '</div>';
		        
		        $html[] = '<div class="url2">';
		        $html[] = '<a href="/calendar/create/';
		        $html[] = $day->getUrlName(); 
		        $html[] = '">+</a>';
		        $html[] = '</div></div>';
		        
		       
		        
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
	
}
