<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditingRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('restaurant_id');
            $table->foreign('restaurant_id')
                ->references('id')->on('restaurants')
                ->onDelete('cascade');
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('email');
            $table->text('description_en');
            $table->text('description_ar');
            $table->integer('telephone');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('editing_restaurants');
    }
}
