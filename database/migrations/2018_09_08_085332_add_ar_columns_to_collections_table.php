<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArColumnsToCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('name_ar')->after('name');
            $table->renameColumn('name', 'name_en');
            $table->string('description_ar')->after('description');
            $table->renameColumn('description', 'description_en');
            $table->string('service_provide_ar')->after('service_provide');
            $table->renameColumn('service_provide', 'service_provide_en');
            $table->string('service_presentation_ar')->after('service_presentation');
            $table->renameColumn('service_presentation', 'service_presentation_en');
            $table->string('requirements_ar')->nullable()->after('requirements');
            $table->renameColumn('requirements', 'requirements_en');
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
            $table->renameColumn('requirements_en', 'requirements');
            $table->dropColumn('requirements_ar');
            $table->renameColumn('service_presentation_en', 'service_presentation');
            $table->dropColumn('service_presentation_ar');
            $table->renameColumn('service_provide_en', 'service_provide');
            $table->dropColumn('service_provide_ar');
            $table->renameColumn('description_en', 'description');
            $table->dropColumn('description_ar');
            $table->renameColumn('name_en', 'name');
            $table->dropColumn('name_ar');
        });
    }
}
