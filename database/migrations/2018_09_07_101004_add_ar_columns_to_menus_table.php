<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArColumnsToMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->string('name_ar')->after('name');
            $table->string('description_ar')->after('description');
            $table->renameColumn('name', 'name_en');
            $table->renameColumn('description', 'description_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->renameColumn('description_en', 'description');
            $table->renameColumn('name_en', 'name');
            $table->dropColumn('description_ar');
            $table->dropColumn('name_ar');
        });
    }
}
