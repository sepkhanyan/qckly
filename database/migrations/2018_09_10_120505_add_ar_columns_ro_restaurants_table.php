<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddArColumnsRoRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('name_ar')->after('name');
            $table->renameColumn('name', 'name_en');
            $table->string('description_ar')->after('description');
            $table->renameColumn('description', 'description_en');
            $table->string('address_ar')->after('address');
            $table->renameColumn('address', 'address_en');
            $table->string('city_ar')->after('city');
            $table->renameColumn('city', 'city_en');
            $table->string('state_ar')->nullable()->after('state');
            $table->renameColumn('state', 'state_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->renameColumn('state_en', 'state');
            $table->dropColumn('state_ar');
            $table->renameColumn('city_en', 'city');
            $table->dropColumn('city_ar');
            $table->renameColumn('address_en', 'address');
            $table->dropColumn('address_ar');
            $table->renameColumn('description_en', 'description');
            $table->dropColumn('description_ar');
            $table->renameColumn('name_en', 'name');
            $table->dropColumn('name_ar');
        });
    }
}
