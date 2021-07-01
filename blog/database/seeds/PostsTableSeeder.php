<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i=0;$i<10;$i++){
            DB::table('posts')->insert([
            'title' => $faker->name,
            'body' => $faker->sentence,
            'created_at' =>now(),
            'updated_at' =>now(),
            ]);
        }
    }
    
   
}
