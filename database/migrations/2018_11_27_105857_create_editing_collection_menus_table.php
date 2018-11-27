<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditingCollectionMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_collection_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('editing_collection_id');
            $table->foreign('editing_collection_id')
                ->references('id')->on('editing_collections')
                ->onDelete('cascade');
            $table->unsignedInteger('menu_id');
            $table->foreign('menu_id')
                ->references('id')->on('menu_categories')
                ->onDelete('cascade');
            $table->integer('max_qty')->nullable();
            $table->integer('min_qty')->nullable();
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
        Schema::dropIfExists('editing_collection_menus');
    }
}
