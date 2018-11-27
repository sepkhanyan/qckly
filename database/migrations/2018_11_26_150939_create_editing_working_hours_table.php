<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditingWorkingHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_working_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('editing_restaurant_id');
            $table->foreign('editing_restaurant_id')
                ->references('id')->on('editing_restaurants')
                ->onDelete('cascade');
            $table->integer('weekday')->nullable();
            $table->time('opening_time')->default('00:00:00');
            $table->time('closing_time')->default('00:00:00');
            $table->tinyInteger('status');
            $table->string('type');
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
        Schema::dropIfExists('editing_working_hours');
    }
}
