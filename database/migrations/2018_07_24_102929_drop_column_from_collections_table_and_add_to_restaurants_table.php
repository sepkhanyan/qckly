<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnFromCollectionsTableAndAddToRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('female_caterer_available');

        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->tinyInteger('female_caterer_available');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->tinyInteger('female_caterer_available');

        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropColumn('female_caterer_available');

        });
    }
}
