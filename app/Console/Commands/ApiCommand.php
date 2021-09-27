<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:wheather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get wheather info';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
        	CURLOPT_URL => "https://community-open-weather-map.p.rapidapi.com/forecast?q=Tokyo%2C%20JP&lang=ja",
        	CURLOPT_RETURNTRANSFER => false,
        	CURLOPT_FOLLOWLOCATION => true,
        	CURLOPT_ENCODING => "",
        	CURLOPT_MAXREDIRS => 10,
        	CURLOPT_TIMEOUT => 30,
        	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        	CURLOPT_CUSTOMREQUEST => "GET",
        	CURLOPT_HTTPHEADER => [
        		"x-rapidapi-host: community-open-weather-map.p.rapidapi.com",
        		"x-rapidapi-key: " . env("RAPIDAPI_KEY") 
        	],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
        	echo "cURL Error #:" . $err;
        } else {
            $obj = json_encode($response);
            echo($obj.wheather);
            
        }
    }
}
