<?php

namespace App\Calendar;

use App\Models\Weather;

class WeatherApi {
	
	public function __construct () 
	{
		//
	}
	
	public static function getWeather() 
	{
		
		$city_name = 'Tokyo';
		$WEATHER_KEY = env('WEATHER_KEY');
		$url = "https://api.openweathermap.org/data/2.5/forecast?q=" . $city_name . "&appid=" . $WEATHER_KEY;
		$context = stream_context_create([
		    'http' => [
		        'timeout' => 30
		    ]
		]);
		$get = file_get_contents($url, false, $context);
		
		if(!$get) {
			
			echo 'failed';	
			
		} else {
			//echo("success");
			
			$json = json_decode($get, true);
			Weather::query()->forceDelete();
			
			$cnt = count($json['list']);
			$sky = array();
			$time = array();
			$temp = array();
			$desc = array();
			$humidity = array();
			
			for($i = 0; $i < $cnt; $i++){
			    $sky[] = $json['list'][$i]['weather'][0]['main'];
			    $desc[] = $json['list'][$i]['weather'][0]['description'];
			    $temp[] = floor($json['list'][$i]['main']['temp'] - 273.15 );
			    $humidity[] = floor($json['list'][$i]['main']['humidity']);
			    $time[] = $json['list'][$i]['dt_txt'];
			    
			    Weather::create([
		            'sky' => $json['list'][$i]['weather'][0]['main'],
		            'desc' => $json['list'][$i]['weather'][0]['description'],
		            'city' => $city_name,
		            'humidity' => floor($json['list'][$i]['main']['humidity']),
		            'temp' => floor($json['list'][$i]['main']['temp'] - 273.15 ),
		            'dt_txt' => $json['list'][$i]['dt_txt'],
		        ]);
			}
		} 
		//echo $json['cod'];
		//echo $weather = ['sky' => $sky, 'desc' => $desc, 'time' => $time, 'temp' => $temp, 'humidity' => $humidity];
	}


}