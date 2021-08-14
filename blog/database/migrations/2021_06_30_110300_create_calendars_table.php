<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//https://readouble.com/laravel/6.x/ja/migrations.html

// ## マイグレーション
// php artisan migrate:refresh --seed

class CreateCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->bigIncrements('calendar_id');
            $table->integer('personal_id');
            $table->date('date');
            $table->timeTz('start_time', 0);
            $table->date('date_fin');
            $table->timeTz('finish_time', 0);
            $table->integer('parent_id')->default(null);
            $table->integer('group_id');
            $table->integer('block');
            $table->timestampsTz(0);
            $table->softDeletes();
            //integer
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendars');
    }
}
