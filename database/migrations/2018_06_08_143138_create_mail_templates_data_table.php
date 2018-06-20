<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTemplatesDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_templates_data', function (Blueprint $table) {
            $table->increments('template_data_id');
            $table->integer('template_id');
            $table->string('code',32);
            $table->string('subject',32);
            $table->text('body');
            $table->dateTime('date_added');
            $table->dateTime('date_updated');
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
        Schema::dropIfExists('mail_templates_data');
    }
}
