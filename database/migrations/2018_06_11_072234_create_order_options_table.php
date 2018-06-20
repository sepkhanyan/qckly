<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_options', function (Blueprint $table) {
            $table->increments('order_option_id');
            $table->integer('order_id');
            $table->integer('menu_id');
            $table->string('order_option_name',128);
            $table->decimal('order_option_price',15,4);
            $table->integer('order_menu_id');
            $table->integer('order_menu_option_id');
            $table->integer('menu_option_value_id');
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
        Schema::dropIfExists('order_options');
    }
}
