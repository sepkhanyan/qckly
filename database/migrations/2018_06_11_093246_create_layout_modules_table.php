<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayoutModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layout_modules', function (Blueprint $table) {
            $table->increments('layout_module_id');
            $table->integer('layout_id');
            $table->string('module_code',128);
            $table->string('partial',32);
            $table->integer('priority');
            $table->text('options');
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
        Schema::dropIfExists('layout_modules');
    }
}
