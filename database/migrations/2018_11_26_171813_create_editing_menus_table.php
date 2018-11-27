<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditingMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menu_id');
            $table->foreign('menu_id')
                ->references('id')->on('menus')
                ->onDelete('cascade');
            $table->string('name_en');
            $table->string('name_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->float('price');
            $table->string('image')->nullable();
            $table->tinyInteger('famous');
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
        Schema::dropIfExists('editing_menus');
    }
}
