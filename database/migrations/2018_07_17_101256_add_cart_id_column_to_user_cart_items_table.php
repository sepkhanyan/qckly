<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCartIdColumnToUserCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_cart_items', function (Blueprint $table) {
            $table->integer('cart_id')->unsigned();
            $table->foreign('cart_id')->references('id')->on('user_carts')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_cart_items', function (Blueprint $table) {
            $table->dropColumn('cart_id');
        });
    }
}
