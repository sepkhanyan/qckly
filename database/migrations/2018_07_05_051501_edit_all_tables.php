<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function(Blueprint $table) {
            $table->renameColumn('category_id', 'id');
        });

        Schema::table('menus', function(Blueprint $table) {
            $table->renameColumn('menu_id', 'id');
        });

        Schema::table('restaurants', function(Blueprint $table) {
            $table->renameColumn('restaurant_id', 'id');
        });

        Schema::table('restaurant_categories', function(Blueprint $table) {
            $table->renameColumn('restaurant_category_id', 'id');
        });


    }


    public function down()
    {
        Schema::table('categories', function(Blueprint $table) {
            $table->renameColumn('id', 'category_id');
        });

        Schema::table('menus', function(Blueprint $table) {
            $table->renameColumn('id', 'menu_id');
        });

        Schema::table('restaurants', function(Blueprint $table) {
            $table->renameColumn('id', 'restaurant_id');
        });

        Schema::table('restaurant_categories', function(Blueprint $table) {
            $table->renameColumn('id', 'restaurant_category_id');
        });


    }
}
