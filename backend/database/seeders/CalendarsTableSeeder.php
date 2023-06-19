<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use carbon\carbon;

class CalendarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    /*
        $table->bigIncrements('calendar_id');
            $table->unsignedInteger('personal_id');
            $table->timeTz('start_time', 0);
            $table->timeTz('finish_time', 0);
            $table->unsignedInteger('group_id');
            $table->timestampsTz(0);
            $table->softDeletesTz('deleted_at')->nullable();
    */       
    public function run(Faker $faker)
    {
        
        for($i=0;$i<400;$i++){
            $tmp = $faker->date($format = '2021-8-d', $max = now());
            
            $start = $faker->dateTimeBetween($startDate = '00:00:00', $endDate = '11:59:59')->format('H:i');
            $end = $faker->dateTimeBetween($startDate = '12:00:00', $endDate = '23:59:59')->format('H:i');
            
            DB::table('calendars')->insert([
                
                'personal_id' => $faker->NumberBetween($min = 14, $max = 20),
                'date' => $tmp,
                'start_time' => $start,
                'date_fin' => $tmp,
                'finish_time' => $end,
                'block' => round((strtotime($end)-strtotime($start))/1800),
                'group_id' => 1,
                'created_at' =>now(),
                'updated_at' =>now(),
                'deleted_at' =>NULL,
            ]);
        }
    }
    
}
