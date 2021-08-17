<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i=0;$i<5;$i++){
            DB::table('chats')->insert([
                'personal_id' => 1,
                'group_id' => 1,
                'text' => $faker->sentence,
                'created_at' =>now(),
                'updated_at' =>now(),
                ]);
        }
    }
}
