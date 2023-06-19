<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(CalendarsTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        //$this->call(ProfilerTableSeeder::class);
        $this->call(ChatsTableSeeder::class);
    }
}
