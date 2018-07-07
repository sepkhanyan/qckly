<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnFromRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints('restaurants', function(Blueprint $table) {
            $table->dropForeign(['restaurant_category_id']);
            $table->integer('restaurant_category_id')->nullable()->change();
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants', function(Blueprint $table) {
            $table->integer('restaurant_category_id')->change();
        });
    }
}
