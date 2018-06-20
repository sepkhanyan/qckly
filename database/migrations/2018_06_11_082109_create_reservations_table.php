<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('reservation_id');
            $table->integer('location_id');
            $table->integer('table_id');
            $table->integer('guest_num');
            $table->integer('occasion_id');
            $table->integer('customer_id');
            $table->string('first_name',45);
            $table->string('last_name',45);
            $table->string('email',96);
            $table->string('telephone',45);
            $table->text('comment');
            $table->time('reserve_time');
            $table->date('reserve_date');
            $table->date('date_added');
            $table->date('date_modified');
            $table->integer('assignee_id');
            $table->tinyInteger('notify');
            $table->string('ip_address',40);
            $table->string('user_agent',255);
            $table->tinyInteger('status');
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
        Schema::dropIfExists('reservations');
    }
}
