<?php

use Illuminate\Database\Seeder;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('shops')->insert([
            'shop' => 'laravel1',
            'created_at' =>now(),
            'updated_at' =>now(),
        ]);
        DB::table('shops')->insert([
            'shop' => 'laravel2',
            'created_at' =>now(),
            'updated_at' =>now(),
        ]);
        
    }
}
