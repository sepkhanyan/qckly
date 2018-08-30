<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->renameColumn('language_id', 'id');
            $table->string('code')->nullable()->change();
            $table->string('idiom')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->renameColumn('id', 'language_id');
            $table->string('code')->nullable(false)->change();
            $table->string('idiom')->nullable(false)->change();
        });
    }
}
