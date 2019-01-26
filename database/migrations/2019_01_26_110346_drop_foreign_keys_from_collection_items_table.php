<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignKeysFromCollectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collection_items', function (Blueprint $table) {
            $table->dropForeign(['collection_id']);
            $table->dropForeign(['collection_menu_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collection_items', function (Blueprint $table) {
            $table->integer('collection_id')->unsigned()->change();
            $table->foreign('collection_id')
                ->references('id')->on('collections')
                ->onDelete('cascade');
            $table->integer('collection_menu_id')->unsigned()->change();
            $table->foreign('collection_menu_id')
                ->references('id')->on('menu_categories')
                ->onDelete('cascade');
        });
    }
}
