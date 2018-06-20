<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('customer_id');
            $table->string('first_name', 32);
            $table->string('last_name', 32);
            $table->string('email', 96);
            $table->string('password', 40);
            $table->string('salt');
            $table->string('telephone');
            $table->integer('adress_id');
            $table->integer('security_question_id');
            $table->string('security_answer', 32);
            $table->tinyInteger('newsletter');
            $table->integer('customer_group_id');
            $table->integer('ip_address');
            $table->dateTime('date_added');
            $table->tinyInteger('status');
            $table->text('cart');
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
        Schema::dropIfExists('customers');
    }
}
