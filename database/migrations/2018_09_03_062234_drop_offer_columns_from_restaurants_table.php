<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropOfferColumnsFromRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('offer_delivery');
            $table->dropColumn('offer_collection');
            $table->dropColumn('delivery_time');
            $table->dropColumn('last_order_time');
            $table->dropColumn('reservation_interval');
            $table->dropColumn('reservation_turn');
            $table->dropColumn('collection_time');

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
            $table->tinyInteger('offer_delivery');
            $table->tinyInteger('offer_collection');
            $table->integer('delivery_time');
            $table->integer('last_order_time');
            $table->integer('reservation_interval');
            $table->integer('reservation_turn');
            $table->integer('collection_time');
        });

    }
}
