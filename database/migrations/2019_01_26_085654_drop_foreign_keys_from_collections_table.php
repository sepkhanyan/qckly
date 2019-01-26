<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignKeysFromCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropForeign(['restaurant_id']);
            $table->renameColumn('category_id', 'subcategory_id');
            $table->dropForeign(['subcategory_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->integer('restaurant_id')->unsigned()->change();
            $table->foreign('restaurant_id')
                ->references('id')->on('restaurants')
                ->onDelete('cascade');
            $table->integer('subcategory_id')->unsigned()->change();
            $table->foreign('subcategory_id')
                ->references('id')->on('collection_categories')
                ->onDelete('cascade');
        });
    }
}
