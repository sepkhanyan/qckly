<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCartMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_cart_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id');
            $table->integer('collection_id');
            $table->integer('cart_collection_id')->unsigned();
            $table->foreign('cart_collection_id')->references('id')->on('user_cart_collections')->onDelete('cascade');
            $table->integer('cart_id')->unsigned();
            $table->foreign('cart_id')->references('id')->on('user_carts')->onDelete('cascade');
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
        Schema::dropIfExists('user_cart_menus');
    }
}
