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
            'shop_name' => 'laravel1',
            'group_id' => '1',
            'shop' => 'def',
            'created_at' =>now(),
            'updated_at' =>now(),
        ]);
        DB::table('shops')->insert([
            'shop_name' => 'laravel2',
            'group_id' => '1',
            'shop' => 'abc',
            'created_at' =>now(),
            'updated_at' =>now(),
        ]);
        
    }
}
