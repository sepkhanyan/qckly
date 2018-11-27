<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApprovedColumntToMenuCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_categories', function (Blueprint $table) {
            $table->tinyInteger('approved')->after('image')->default(0);
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->tinyInteger('approved')->after('famous')->default(0);
        });
        Schema::table('collections', function (Blueprint $table) {
            $table->tinyInteger('approved')->after('female_caterer_available')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_categories', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
    }
}
