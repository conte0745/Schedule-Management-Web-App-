<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('users')->insert([
            'name' => $faker->name,
            'group_id' => 1,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '00000000', // password
            'remember_token' => Str::random(10),
            'color' => '#fff8dc',
            'state' => 'happy',
            'permission' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        for($i=0;$i<20;$i++){
            DB::table('users')->insert([
            'name' => $faker->name,
            'group_id' => 1,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '00000000', // password
            'remember_token' => Str::random(10),
            'color' => '#fff8dc',
            'state' => 'happy',
            'permission' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        }
        
    }
}



