<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_meta', function (Blueprint $table) {
            $table->increments('message_meta_id');
            $table->integer('message_id');
            $table->tinyInteger('state');
            $table->tinyInteger('status');
            $table->tinyInteger('deleted');
            $table->string('item',32);
            $table->text('value');
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
        Schema::dropIfExists('message_recipients');
    }
}
