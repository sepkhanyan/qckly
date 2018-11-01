<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsTypeForAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('name_en', 255)->change();
            $table->string('name_ar',255)->change();
            $table->text('service_provide_ar')->change();
            $table->text('requirements_ar')->change();
            $table->text('description_ar')->change();
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->text('description_ar')->change();
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->text('description_ar')->change();
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
            $table->string('name_en')->change();
            $table->string('name_ar')->change();
            $table->string('service_provide_ar')->change();
            $table->string('requirements_ar')->change();
            $table->string('description_ar')->change();
        });
        Schema::table('menus', function (Blueprint $table) {
            $table->string('description_ar')->change();
        });
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('description_ar')->change();
        });
    }
}
