<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignKeysFromCollectionMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collection_menus', function (Blueprint $table) {
            $table->dropForeign(['collection_id']);
            $table->dropForeign(['menu_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collection_menus', function (Blueprint $table) {
            $table->integer('collection_id')->unsigned()->change();
            $table->foreign('collection_id')
                ->references('id')->on('collections')
                ->onDelete('cascade');
            $table->integer('menu_id')->unsigned()->change();
            $table->foreign('menu_id')
                ->references('id')->on('menu_categories')
                ->onDelete('cascade');
        });
    }
}
