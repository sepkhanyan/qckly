<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFoodlistFieldToEditingCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editing_collections', function (Blueprint $table) {
            $table->text('food_list_en')->after('description_ar');
            $table->text('food_list_ar')->after('food_list_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('editing_collections', function (Blueprint $table) {
            $table->dropColumn('food_list_en');
            $table->dropColumn('food_list_ar');
        });
    }
}
