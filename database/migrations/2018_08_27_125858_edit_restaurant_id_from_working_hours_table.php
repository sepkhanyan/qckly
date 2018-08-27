<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditRestaurantIdFromWorkingHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('working_hours', function (Blueprint $table) {
            $table->integer('restaurant_id')->unsigned()->change();
        });

        Schema::table('working_hours', function (Blueprint $table) {
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
        Schema::table('working_hours', function (Blueprint $table) {
            $table->dropForeign(['restaurant_id']);
        });
    }
}
