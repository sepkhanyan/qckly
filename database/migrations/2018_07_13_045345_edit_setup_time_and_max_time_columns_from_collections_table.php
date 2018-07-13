<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditSetupTimeAndMaxTimeColumnsFromCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function(Blueprint $table) {
            $table->string('setup_time')->change();
            $table->string('max_time')->change();
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collections', function(Blueprint $table) {
            $table->time('setup_time')->change();
            $table->time('max_time')->change();
        });
    }
}
