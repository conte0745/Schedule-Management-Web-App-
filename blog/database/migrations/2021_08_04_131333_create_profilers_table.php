<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profilers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('personal_id');
            $table->integer('group_id');
            $table->integer('state')->nullable($value = true);
            $table->integer('color')->nullable($value = NULL);
            $table->boolean('permission')->default(False);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profilers');
    }
}
