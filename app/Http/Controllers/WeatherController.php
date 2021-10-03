<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weather;

class WeatherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() 
    {
        $weathers = Weather::all()->toArray();
        
        $result = array();
        foreach($weathers as $weather){
            $result[substr($weather['dt_txt'],0 ,10)][] = [substr($weather['dt_txt'], 11, 20), $weather['temp'] . '℃', $weather['humidity'] .'%', $weather['sky'], $weather['desc']];
        }
        //dd($result);
        return view('weather.index')->with(['data' => $result]);
    }   
}
