<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameCollectionIdColumnFromUserCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_cart_items', function (Blueprint $table) {
            $table->renameColumn('collection_id', 'cart_collection_id');
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
            $table->renameColumn('cart_collection_id', 'collection_id');
        });
    }
}
