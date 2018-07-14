<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditMenuSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menu_subcategories', function (Blueprint $table) {
            $table->renameColumn('subcategory_name', 'subcategory_en');
            $table->string('subcategory_ar');
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
            $table->renameColumn('subcategory_en', 'subcategory_name');
            $table->dropColumn('subcategory_ar');
        });
    }
}
