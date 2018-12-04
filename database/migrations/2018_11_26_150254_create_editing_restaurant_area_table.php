<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditingRestaurantAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_restaurant_area', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('editing_restaurant_id');
            $table->foreign('editing_restaurant_id')
                ->references('id')->on('editing_restaurants')
                ->onDelete('cascade');
            $table->unsignedInteger('area_id');
            $table->foreign('area_id')
                ->references('id')->on('areas')
                ->onDelete('cascade');
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
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
        Schema::dropIfExists('editing_restaurant_area');
    }
}
