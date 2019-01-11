<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyToCategoryIdColumnFromCategoryRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_restaurant', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->change();
        });

        Schema::table('category_restaurant', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('restaurant_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_restaurant', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
    }
}
