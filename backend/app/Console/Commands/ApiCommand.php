<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Calendar\WeatherApi;

class ApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:weather';

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
        WeatherApi::getWeather();
    }
}
