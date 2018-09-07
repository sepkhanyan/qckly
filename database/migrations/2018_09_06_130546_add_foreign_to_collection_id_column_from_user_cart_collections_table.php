<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignToCollectionIdColumnFromUserCartCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_cart_collections', function (Blueprint $table) {
            $table->integer('collection_id')->unsigned()->change();
        });

        Schema::table('user_cart_collections', function (Blueprint $table) {
            $table->foreign('collection_id')
                ->references('id')->on('collections')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_cart_collections', function (Blueprint $table) {
            $table->dropForeign(['collection_id']);
        });
    }
}
