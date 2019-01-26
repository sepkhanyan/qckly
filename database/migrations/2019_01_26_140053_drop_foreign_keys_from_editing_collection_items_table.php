<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignKeysFromEditingCollectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editing_collection_items', function (Blueprint $table) {
            $table->dropForeign(['collection_menu_id']);
            $table->dropForeign(['item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('editing_collection_items', function (Blueprint $table) {
            $table->integer('collection_menu_id')->unsigned()->change();
            $table->foreign('collection_menu_id')
                ->references('id')->on('menu_categories')
                ->onDelete('cascade');
            $table->integer('item_id')->unsigned()->change();
            $table->foreign('item_id')
                ->references('id')->on('menus')
                ->onDelete('cascade');
        });
    }
}
