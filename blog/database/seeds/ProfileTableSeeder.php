<?php

use Illuminate\Database\Seeder;

class ProfilerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<20;$i++){
            DB::table('profilers')->insert([
                'personal_id' => $i+1,
                'group_id' => 1,
                'state' => 1,
                'clolor' => 1,
                'permission' => 0,
            ]);
        }
        
        
    }
}
