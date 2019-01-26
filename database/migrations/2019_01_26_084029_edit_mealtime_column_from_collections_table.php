<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditMealtimeColumnFromCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->renameColumn('mealtime_id', 'mealtime');
            $table->dropForeign(['mealtime']);
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
            $table->integer('mealtime')->unsigned()->change();
            $table->foreign('mealtime')
                ->references('id')->on('mealtimes')
                ->onDelete('cascade');
            $table->renameColumn('mealtime', 'mealtime_id');
        });
    }
}
