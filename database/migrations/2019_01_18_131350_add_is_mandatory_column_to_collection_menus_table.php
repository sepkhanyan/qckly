<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsMandatoryColumnToCollectionMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collection_menus', function (Blueprint $table) {
            $table->tinyInteger('is_mandatory')->default(0)->after('max_qty');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collection_menus', function (Blueprint $table) {
            $table->dropColumn('is_mandatory');

        });
    }
}
