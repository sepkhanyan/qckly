<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsFromCategoryRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_restaurant', function (Blueprint $table) {
            $table->renameColumn('category_name_en', 'name_en');
            $table->renameColumn('category_name_ar', 'name_ar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_restaurant', function (Blueprint $table) {
            $table->renameColumn('name_en', 'category_name_en');
            $table->renameColumn('name_ar', 'category_name_ar');
        });
    }
}
