<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->increments('staff_id');
            $table->string('staff_name',32);
            $table->string('staff_email',96)->unique();
            $table->integer('staff_group_id');
            $table->integer('staff_location_id');
            $table->string('timezone',32);
            $table->integer('language_id');
            $table->date('date_added');
            $table->tinyInteger('staff_status');
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
        Schema::dropIfExists('staffs');
    }
}
