<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAllowPersonIncreaseToCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->tinyInteger('allow_person_increase')->nullable();
            $table->dropColumn('persons_min_count');
            $table->integer('min_serve_to_person')->nullable();
            $table->integer('max_serve_to_person')->nullable();
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
            $table->dropColumn('allow_person_increase');
            $table->integer('persons_min_count')->nullable();
            $table->dropColumn('min_serve_to_person');
            $table->dropColumn('max_serve_to_person');
        });
    }
}
