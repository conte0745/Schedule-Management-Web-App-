<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'shop' => 'def',
            'created_at' =>now(),
            'updated_at' =>now(),
        ]);
        DB::table('shops')->insert([
            'shop_name' => 'laravel2',
            'shop' => 'abc',
            'created_at' =>now(),
            'updated_at' =>now(),
        ]);
    }
}
