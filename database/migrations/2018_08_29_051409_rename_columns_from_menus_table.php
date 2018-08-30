<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsFromMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('menu_name', 'name');
            $table->renameColumn('menu_description', 'description');
            $table->renameColumn('menu_price', 'price');
            $table->renameColumn('menu_photo', 'image');
            $table->renameColumn('menu_category_id', 'category_id');
            $table->renameColumn('menu_status', 'status');
            $table->renameColumn('menu_priority', 'priority');
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
            $table->renameColumn('name', 'menu_name');
            $table->renameColumn('description', 'menu_description');
            $table->renameColumn('price', 'menu_price');
            $table->renameColumn('image', 'menu_photo');
            $table->renameColumn('category_id', 'menu_category_id');
            $table->renameColumn('priority', 'menu_priority');
        });
    }
}
