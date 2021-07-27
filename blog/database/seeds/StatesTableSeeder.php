<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states')->insert([
            'state' => 'fun',
            'created_at' =>now(),
            'updated_at' =>now(),
        ]);
    }
}
