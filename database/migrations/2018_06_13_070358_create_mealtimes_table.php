<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mealtimes', function (Blueprint $table) {
            $table->increments('mealtime_id');
            $table->string('mealtime_name');
            $table->time('start_time')->default('00:00:00');
            $table->time('end_time')->default('23:59:59');
            $table->tinyInteger('mealtime_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mealtimes');
    }
}
