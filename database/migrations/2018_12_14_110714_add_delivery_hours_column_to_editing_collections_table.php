<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryHoursColumnToEditingCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editing_collections', function (Blueprint $table) {
            $table->integer('delivery_hours')->after('female_caterer_available')->nullable();
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
            $table->dropColumn('delivery_hours');
        });
    }
}
