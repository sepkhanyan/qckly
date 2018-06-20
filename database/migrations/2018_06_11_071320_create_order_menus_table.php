<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_menus', function (Blueprint $table) {
            $table->increments('order_menu_id');
            $table->integer('order_id');
            $table->integer('menu_id');
            $table->string('name',255);
            $table->integer('quantity');
            $table->decimal('price',15,4)->default('0.00');
            $table->decimal('subtotal',15,4)->default('0.00');
            $table->text('option_value');
            $table->text('comment');
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
        Schema::dropIfExists('order_menus');
    }
}
