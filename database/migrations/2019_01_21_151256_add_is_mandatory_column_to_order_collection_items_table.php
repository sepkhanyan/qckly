<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsMandatoryColumnToOrderCollectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_collection_items', function (Blueprint $table) {
            $table->tinyInteger('is_mandatory')->default(0)->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_collection_items', function (Blueprint $table) {
            $table->dropColumn('is_mandatory');
        });
    }
}
