<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('service_provide');
            $table->text('instruction');
            $table->time('setup_time');
            $table->time('max_time');
            $table->text('requirements');
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
            $table->dropColumn('service_provide');
            $table->dropColumn('instruction');
            $table->dropColumn('setup_time');
            $table->dropColumn('max_time');
            $table->dropColumn('requirements');
        });
    }
}
