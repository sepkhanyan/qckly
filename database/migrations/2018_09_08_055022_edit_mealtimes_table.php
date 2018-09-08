<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditMealtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mealtimes', function (Blueprint $table) {
            $table->renameColumn('mealtime_id', 'id');
            $table->string('name_ar')->after('mealtime_name');
            $table->renameColumn('mealtime_name', 'name_en');
            $table->dropColumn('mealtime_status');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mealtimes', function (Blueprint $table) {
            $table->tinyInteger('mealtime_status');
            $table->renameColumn('name_en','mealtime_name');
            $table->dropColumn('name_ar');
            $table->renameColumn('id', 'mealtime_id');
        });
    }
}
