<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function index(Request $request)
    {
        $param = $request->all();
        
        if(!array_key_exists('num', $param)) 
            $param['num'] = 30;
        else {
            if($param['num'] < 3)
                $param['num'] = 5;
        } 
            
        if(!array_key_exists('cnt', $param)) 
            $param['cnt'] = 5;
        
        
        $random = array();
        for($i=0;$i<$param['cnt'];$i++){
            
            $tmp = chr(mt_rand(65, 90));
            
            for($j=0;$j<$param['num'] - 2;$j++){
                if(mt_rand(0, 1) == 1)
                    $tmp .= chr(mt_rand(33, 90));    
                else
                    $tmp .= chr(mt_rand(95, 126));    
            }
            
            $tmp .= chr(mt_rand(97, 122));
            
            array_push($random, $tmp);
        }
        
        return view('random')->with(['random' => $random]);
    }
}
