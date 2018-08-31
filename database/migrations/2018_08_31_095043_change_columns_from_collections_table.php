<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsFromCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->integer('setup_time')->nullable()->change();
            $table->integer('max_time')->nullable()->change();
            $table->text('requirements')->nullable()->change();
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
            $table->integer('setup_time')->nullable(false)->change();
            $table->integer('max_time')->nullable(false)->change();
            $table->text('requirements')->nullable(false)->change();
        });
    }
}
