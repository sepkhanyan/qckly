<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditRestaurantIdFromRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->integer('restaurant_id')->unsigned()->change();
        });

        Schema::table('ratings', function (Blueprint $table) {
            $table->foreign('restaurant_id')
                ->references('id')->on('restaurants')
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
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropForeign(['restaurant_id']);
        });
    }
}
