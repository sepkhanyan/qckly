<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditPriceColumnsFromCollectionsAndCollectionItemsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->float('price')->nullable()->change();

        });
        Schema::table('collection_items', function (Blueprint $table) {
            $table->float('price')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->float('price')->nullable(false)->change();

        });
        Schema::table('collection_items', function (Blueprint $table) {
            $table->decimal('price')->change();

        });
    }
}
