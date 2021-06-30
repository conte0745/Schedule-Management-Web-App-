<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
//https://readouble.com/laravel/6.x/ja/migrations.html

// ## マイグレーションを指定したファイルから１つだけ
// php artisan migrate:refresh  --step=1 --path=/database/migrations/2021_06_30_110300_create_calendars_table.php

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
            $table->unsignedIntenger('personal_id');
            $table->timeTz('start_time', 0);
            $table->timeTz('finish_time', 0);
            $table->unsignedIntenger('group_id');
            $table->timestampsTz(0);
            $table->softDeleteTz(0)->nullable();
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
