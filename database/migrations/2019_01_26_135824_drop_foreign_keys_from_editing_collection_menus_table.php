<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignKeysFromEditingCollectionMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editing_collection_menus', function (Blueprint $table) {
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
        Schema::table('editing_collection_menus', function (Blueprint $table) {
            $table->integer('menu_id')->unsigned()->change();
            $table->foreign('menu_id')
                ->references('id')->on('menu_categories')
                ->onDelete('cascade');
        });
    }
}
