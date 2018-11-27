<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditingCategoryRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_category_restaurant', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('editing_restaurant_id');
            $table->foreign('editing_restaurant_id')
                ->references('id')->on('editing_restaurants')
                ->onDelete('cascade');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                ->references('id')->on('restaurant_categories')
                ->onDelete('cascade');
            $table->string('name_en');
            $table->string('name_ar');
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
        Schema::dropIfExists('editing_category_restaurant');
    }
}
