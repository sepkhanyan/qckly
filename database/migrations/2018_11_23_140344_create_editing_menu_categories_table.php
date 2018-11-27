<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditingMenuCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_menu_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                ->references('id')->on('menu_categories')
                ->onDelete('cascade');
            $table->string('name_en');
            $table->string('name_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->string('image')->nullable();
            $table->tinyInteger('approved')->default(0);
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
        Schema::dropIfExists('editing_menu_categories');
    }
}
