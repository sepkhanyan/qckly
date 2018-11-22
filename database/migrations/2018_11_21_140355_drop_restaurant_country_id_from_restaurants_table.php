<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropRestaurantCountryIdFromRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
//            $table->dropForeign(['restaurant_country_id']);
            $table->dropColumn('restaurant_country_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->unsignedInteger('restaurant_country_id');
            $table->foreign('restaurant_country_id')
                ->references('id')->on('areas')
                ->onDelete('cascade');
        });
    }
}
