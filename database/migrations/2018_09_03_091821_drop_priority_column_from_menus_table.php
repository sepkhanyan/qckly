<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPriorityColumnFromMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('stock_qty');
            $table->dropColumn('minimum_qty');
            $table->dropColumn('subtract_stock');
            $table->dropColumn('priority');
            $table->dropColumn('mealtime');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->integer('stock_qty');
            $table->integer('minimum_qty');
            $table->tinyInteger('subtract_stock');
            $table->integer('priority');
            $table->integer('mealtime');
        });

    }
}
