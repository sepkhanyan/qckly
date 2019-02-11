<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitleFieldsToEditingCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editing_collections', function (Blueprint $table) {
            $table->string('container_title_en')->after('description_ar');
            $table->string('container_title_ar')->after('container_title_en');
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
            $table->dropColumn('container_title_en');
            $table->dropColumn('container_title_ar');
        });
    }
}
