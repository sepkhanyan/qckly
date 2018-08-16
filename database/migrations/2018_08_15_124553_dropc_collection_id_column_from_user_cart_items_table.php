<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropcCollectionIdColumnFromUserCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_cart_items', function (Blueprint $table) {
            $table->dropColumn('collection_id');
            $table->dropForeign(['cart_id']);
            $table->dropColumn('cart_id');
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
            $table->integer('collection_id');
            $table->integer('cart_id');

        });

    }
}
