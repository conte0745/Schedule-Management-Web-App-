<?php

namespace App\Calendar;

use App\Models\Weather;

class WeatherApi {
	
	private $ja;
	
	public function __construct () 
	{
		
	}
	public static function getWeather() 
	{
		// $en = [
		// 	'200' => ['Thunderstorm','thunderstorm with light rain','11d'],
		// 	'201' => ['Thunderstorm','thunderstorm with rain','11d'],
		// 	'202' => ['Thunderstorm','thunderstorm with heavy rain','11d'],
		// 	'210' => ['Thunderstorm','light thunderstorm','11d'],
		// 	'211' => ['Thunderstorm','thunderstorm','11d'],
		// 	'212' => ['Thunderstorm','heavy thunderstorm','11d'],
		// 	'221' => ['Thunderstorm','ragged thunderstorm','11d'],
		// 	'230' => ['Thunderstorm','thunderstorm with light drizzle','11d'],
		// 	'231' => ['Thunderstorm','thunderstorm with drizzle','11d'],
		// 	'232' => ['Thunderstorm','thunderstorm with heavy drizzle','11d'],
		// 	'300' => ['Drizzle','light intensity drizzle','09d'],
		// 	'301' => ['Drizzle','drizzle','09d'],
		// 	'302' => ['Drizzle','heavy intensity drizzle','09d'],
		// 	'310' => ['Drizzle','light intensity drizzle rain','09d'],
		// 	'311' => ['Drizzle','drizzle rain','09d'],
		// 	'312' => ['Drizzle','heavy intensity drizzle rain','09d'],
		// 	'313' => ['Drizzle','shower rain and drizzle','09d'],
		// 	'314' => ['Drizzle','heavy shower rain and drizzle','09d'],
		// 	'321' => ['Drizzle','shower drizzle','09d'],
		// 	'500' => ['Rain', 'light rain','10d'],
		// 	'501' => ['Rain','moderate rain','10d'],
		// 	'502' => ['Rain','heavy intensity rain','10d'],
		// 	'503' => ['Rain','very heavy rain','10d'],
		// 	'504' => ['Rain','extreme rain','10d'],
		// 	'511' => ['Rain','freezing rain','13d'],
		// 	'520' => ['Rain','light intensity shower rain','09d'],
		// 	'521' => ['Rain','shower rain',' 09d'],
		// 	'522' => ['Rain','heavy intensity shower rain','09d'],
		// 	'531' => ['Rain','ragged shower rain','09d'],
		// 	'600' => ['Snow','light snow','13d'],
		// 	'601' => ['Snow','Snow','13d'],
		// 	'602' => ['Snow','Heavy snow','13d'],
		// 	'611' => ['Snow','Sleet','13d'],
		// 	'612' => ['Snow','Light shower sleet','13d'],
		// 	'613' => ['Snow','Shower sleet',' 13d'],
		// 	'615' => ['Snow','Light rain and snow','13d'],
		// 	'616' => ['Snow','Rain and snow',' 13d'],
		// 	'620' => ['Snow','Light shower snow','13d'],
		// 	'621' => ['Snow','Shower snow','13d'],
		// 	'622' => ['Snow','Heavy shower snow','13d'],
		// 	'701' => ['Mist','mist','50d'],
		// 	'711' => ['Smoke','Smoke','50d'],
		// 	'721' => ['Haze','Haze','50d'],
		// 	'731' => ['Dust','sand dust whirls','50d'],
		// 	'741' => ['Fog','fog','50d'],
		// 	'751' => ['Sand','sand','50d'],
		// 	'761' => ['Dust','dust','50d'],
		// 	'762' => ['Ash','volcanic ash','50d'],
		// 	'771' => ['Squall','squalls','50d'],
		// 	'781' => ['Tornado','tornado','50d'],
		// 	'800' => ['Clear','clear sky','01d'],
		// 	'801' => ['Clouds','few clouds: 11-25%','02d'],
		// 	'802' => ['Clouds','scattered clouds: 25-50%','03d'],
		// 	'803' => ['Clouds','broken clouds: 51-84%','04d'],
		// 	'804' => ['Clouds','overcast clouds: 85-100%','04d']
		// ];
		
		$ja = [
			'200' => ['雷雨', '小雨の雷雨', '11d'],
			'201' => ['雷雨' , '雨の雷雨' , '11d'],
			'202' => ['雷雨' , '大雨を伴う雷雨' , '11d'] ,
			'210' => ['雷雨' , '軽い雷雨' , '11d'] ,
			'211' => ['雷雨' , '雷雨' , '11d'] ,
			'212' => ['雷雨' , '激しい雷雨' , '11d'] ,
			'221' => ['雷雨' , '不規則な雷雨' , '11d'] ,
			'230' => ['雷雨' , '軽い霧雨を伴う雷雨' , '11d'] ,
			'231' => ['雷雨' , '霧雨を伴う雷雨' , '11d'] ,
			'232' => ['雷雨' , '激しい霧雨を伴う雷雨' , '11d'] ,
			'300' => ['霧雨' , '光強度霧雨' , '09d'] ,
			'301' => ['霧雨' , '霧雨' , '09d'] ,
			'302' => ['霧雨' , '霧雨' , '09d'] ,
			'310' => ['霧雨' , '霧雨' , '09d'] ,
			'311' => ['霧雨' , '霧雨' , '09d'] ,
			'312' => ['霧雨' , '激しい霧雨' , '09d'] ,
			'313' => ['霧雨' , 'にわか雨と霧雨' , '09d'] ,
			'314' => ['霧雨' , '激しいにわか雨' , '09d'] ,
			'321' => ['霧雨' , '激しいにわか雨' , '09d'] ,
			'500' => ['雨' , '小雨' , '10d'] ,
			'501' => ['雨' , '中規模の雨' , '10d'] ,
			'502' => ['雨' , '強い雨' , '10d'] ,
			'503' => ['雨' , 'とても強い雨' , '10d'] ,
			'504' => ['雨' , '激しい雨' , '10d'] ,
			'511' => ['雨' , '冷たい雨' , '13d'] ,
			'520' => ['雨' , 'にわか雨' , '09d'] ,
			'521' => ['雨' , 'にわか雨' , '09d'] ,
			'522' => ['雨' , '激しいにわか雨' , '09d'] ,
			'531' => ['雨' , 'にわか雨' , '09d'] ,
			'600' => ['雪' , '小雪' , '13d'] ,
			'601' => ['雪' , '雪' , '13d'],
			'602' => ['雪', '大雪', '13d'],
			'611' => ['雪', 'みぞれ', '13d'],
			'612' => ['雪', 'みぞれ', '13d'],
			'613' => ['雪', 'みぞれ', '13d'],
			'615' => ['雪', '小雨と雪', '13d'],
			'616' => ['雪', '雨と雪', '13d'],
			'620' => ['雪', 'にわか雪', '13d'],
			'621' => ['雪', 'にわか雪', '13d'],
			'622' => ['雪', 'にわか雪', '13d'],
			'701' => ['靄', '靄', '50d'],
			'711' => ['煙', '煙', '50d'],
			'721' => ['靄', '靄', '50d'],
			'731' => ['塵旋風', '砂塵旋風', '50d'],
			'741' => ['霧', '霧', '50d'],
			'751' => ['砂', '砂埃', '50d'],
			'761' => ['靄', '靄', '50d'],
			'762' => ['灰', '火山灰', '50d'],
			'771' => ['スコール', 'スコール', '50d'],
			'781' => ['トルネード', 'トルネード', '50d'],
			'800' => ['晴天', '晴天', '01d'],
			'801' => ['雲', '雲(11-25％)', '02d'],
			'802' => ['雲', '雲(25-50％)', '03d'],
			'803' => ['雲', '雲(51-84％)', '04d'],
			'804' => ['雲', '雲(85-100％)', '04d']
		];
	
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
			echo("success");
			
			$json = json_decode($get, true);
			Weather::query()->forceDelete();
			
			$cnt = count($json['list']);
			$sky = array();
			$time = array();
			$temp = array();
			$desc = array();
			$humidity = array();
			
			for($i = 0; $i < $cnt; $i++){
			    //$id[] = $json['list'][$i]['weather'][0]['id'];
			    //$sky[] = $json['list'][$i]['weather'][0]['main'];
			    //$desc[] = $json['list'][$i]['weather'][0]['description'];
			    //$temp[] = floor($json['list'][$i]['main']['temp'] - 273.15 );
			    //$humidity[] = floor($json['list'][$i]['main']['humidity']);
			    //$time[] = $json['list'][$i]['dt_txt'];
			    
			    Weather::create([
		            'sky' => $ja[$json['list'][$i]['weather'][0]['id']][0],
		            'desc' => $ja[$json['list'][$i]['weather'][0]['id']][1],
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