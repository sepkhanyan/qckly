<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('location_id');
            $table->string('location_name', 32);
            $table->string('location_email', 96);
            $table->text('description');
            $table->string('location_address_1', 128);
            $table->string('location_address_2', 128)->nullable();
            $table->string('location_city', 128);
            $table->string('location_state', 128)->nullable();
            $table->string('location_postcode', 10);
            $table->integer('location_country_id');
            $table->string('location_telephone', 32);
            $table->float('location_lat', 10,6);
            $table->float('location_lng', 10,6);
            /*$table->integer('location_radius');
            $table->text('covered_area');*/
            $table->tinyInteger('offer_delivery');
            $table->tinyInteger('offer_collection')->nullable();
            $table->integer('delivery_time');
            $table->integer('last_order_time');
            /*$table->decimal('delivery_charge',15,2);
            $table->decimal('min_delivery_total',15,2);*/
            $table->integer('reservation_interval');
            $table->integer('reservation_turn');
            $table->integer('collection_time');
            $table->tinyInteger('location_status');
            /*$table->text('options');
            $table->string('location_image', 255);*/
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
