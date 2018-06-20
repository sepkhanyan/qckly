<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('page_id');
            $table->integer('language_id');
            $table->string('name',32);
            $table->string('title',255);
            $table->string('heading',255);
            $table->text('content');
            $table->string('meta_description',255);
            $table->string('meta_keywords',255);
            $table->integer('layout_id');
            $table->text('navigation');
            $table->dateTime('date_added');
            $table->dateTime('date_updated');
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
        Schema::dropIfExists('pages');
    }
}
