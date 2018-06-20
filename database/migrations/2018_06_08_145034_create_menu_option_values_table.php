<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuOptionValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_option_values', function (Blueprint $table) {
            $table->increments('menu_option_value_id');
            $table->integer('menu_option_id');
            $table->integer('menu_id');
            $table->integer('option_id');
            $table->integer('option_value_id');
            $table->decimal('new_price',15,4);
            $table->integer('quantity');
            $table->tinyInteger('subtract_stock');
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
        Schema::dropIfExists('menu_option_values');
    }
}
