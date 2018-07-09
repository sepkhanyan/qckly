<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->decimal('price_per_person');
            $table->decimal('price_per_quantity');
            $table->decimal('fixed_price');
            $table->tinyInteger('customisable');

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
            $table->dropColumn('price_per_person');
            $table->dropColumn('price_per_quantity');
            $table->dropColumn('fixed_price');
            $table->dropColumn('customisable');
        });
    }
}
