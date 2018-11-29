<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageColumnToCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('image')->after('description_ar');
        });
        Schema::table('editing_collections', function (Blueprint $table) {
            $table->string('image')->after('description_ar');
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
            $table->dropColumn('image');
        });
        Schema::table('editing_collections', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
