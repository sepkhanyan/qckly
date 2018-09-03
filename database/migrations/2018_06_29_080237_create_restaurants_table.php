<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('restaurant_id');
            $table->string('restaurant_name', 32);
            $table->string('restaurant_email', 96);
            $table->text('description');
            $table->string('restaurant_address_1', 128);
            $table->string('restaurant_address_2', 128)->nullable();
            $table->string('restaurant_city', 128);
            $table->string('restaurant_state', 128)->nullable();
            $table->string('restaurant_postcode', 10);
            $table->integer('restaurant_country_id');
            $table->string('restaurant_telephone', 32);
            $table->float('restaurant_lat', 10,6);
            $table->float('restaurant_lng', 10,6);
            $table->tinyInteger('offer_delivery');
            $table->tinyInteger('offer_collection');
            $table->integer('delivery_time');
            $table->integer('last_order_time');
            $table->integer('reservation_interval');
            $table->integer('reservation_turn');
            $table->integer('collection_time');
            $table->tinyInteger('restaurant_status');
            $table->string('restaurant_image', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
