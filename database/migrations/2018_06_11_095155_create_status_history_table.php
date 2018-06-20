<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_history', function (Blueprint $table) {
            $table->increments('status_history_id');
            $table->integer('object_id');
            $table->integer('staff_id');
            $table->integer('assignee_id');
            $table->integer('status_id');
            $table->tinyInteger('notify');
            $table->string('status_for',32);
            $table->text('comment');
            $table->dateTime('date_added');
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
        Schema::dropIfExists('status_history');
    }
}
