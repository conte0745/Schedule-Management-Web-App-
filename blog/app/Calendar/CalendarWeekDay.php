<?php
namespace App\Calendar;
use Carbon\Carbon;
use Yasumi\Yasumi;

class CalendarWeekDay
{
	public $carbon;

	function __construct($date)
	{
		$this->carbon = new Carbon($date);
		//dd($this->carbon);
	}


	function getClassName()
	{
		return "day-" . strtolower($this->carbon->format("D"));
	}
	
	function render()
	{
		return '<p class="day">' . $this->carbon->format('j'). '</p>';
	}
	
	function getUrlName()
	{
		return $this->carbon->format('d');
	}
	
	function getDate()
	{
		return $this->carbon->format('Y-m-d');
	}
	
}