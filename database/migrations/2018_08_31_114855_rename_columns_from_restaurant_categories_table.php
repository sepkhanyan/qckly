<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsFromRestaurantCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurant_categories', function (Blueprint $table) {
            $table->renameColumn('restaurant_category_name_en', 'name_en');
            $table->renameColumn('restaurant_category_name_ar', 'name_ar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurant_categories', function (Blueprint $table) {
            $table->renameColumn('name_en', 'restaurant_category_name_en');
            $table->renameColumn('name_ar', 'restaurant_category_name_ar');
        });
    }
}
