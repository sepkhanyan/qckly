<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditingCollectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_collection_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('editing_collection_id');
            $table->foreign('editing_collection_id')
                ->references('id')->on('editing_collections')
                ->onDelete('cascade');
            $table->unsignedInteger('collection_menu_id')->nullable();
            $table->foreign('collection_menu_id')
                ->references('id')->on('menu_categories')
                ->onDelete('cascade');
            $table->unsignedInteger('item_id');
            $table->foreign('item_id')
                ->references('id')->on('menus')
                ->onDelete('cascade');
            $table->integer('quantity')->nullable();
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
        Schema::dropIfExists('editing_collection_items');
    }
}
