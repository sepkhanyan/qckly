<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_activity', function (Blueprint $table) {
            $table->increments('activity_id');
            $table->integer('customer_id');
            $table->string('access_type', 128);
            $table->string('browser', 128);
            $table->string('ip_address', 40);
            $table->string('country_code', 2);
            $table->text('request_uri');
            $table->text('referrer_uri');
            $table->dateTime('date_added');
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
        Schema::dropIfExists('customers_activity');
    }
}
