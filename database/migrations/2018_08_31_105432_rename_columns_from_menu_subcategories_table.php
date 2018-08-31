<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsFromMenuSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_subcategories', function (Blueprint $table) {
            $table->renameColumn('subcategory_en', 'name_en');
            $table->renameColumn('subcategory_ar', 'name_ar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_subcategories', function (Blueprint $table) {
            $table->renameColumn('name_en', 'subcategory_en');
            $table->renameColumn('name_ar', 'subcategory_ar');
        });
    }
}
