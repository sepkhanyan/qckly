<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsFromRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->renameColumn('restaurant_name', 'name');
            $table->renameColumn('restaurant_email', 'email');
            $table->renameColumn('restaurant_address_1', 'address');
            $table->renameColumn('restaurant_city', 'city');
            $table->renameColumn('restaurant_state', 'state');
            $table->renameColumn('restaurant_postcode', 'postcode');
            $table->renameColumn('restaurant_country_id', 'area_id');
            $table->renameColumn('restaurant_telephone', 'telephone');
            $table->renameColumn('restaurant_lat', 'latitude');
            $table->renameColumn('restaurant_lng', 'longitude');
            $table->renameColumn('restaurant_status', 'status');
            $table->renameColumn('restaurant_image', 'image');
            $table->renameColumn('restaurant_category_id', 'category_id');
            $table->dropColumn('restaurant_address_2');
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
            $table->renameColumn('name', 'restaurant_name');
            $table->renameColumn('email', 'restaurant_email');
            $table->renameColumn('address', 'restaurant_address_1');
            $table->renameColumn('city', 'restaurant_city');
            $table->renameColumn('state', 'restaurant_state');
            $table->renameColumn('postcode', 'restaurant_postcode');
            $table->renameColumn('area_id', 'restaurant_country_id');
            $table->renameColumn('telephone', 'restaurant_telephone');
            $table->renameColumn('latitude', 'restaurant_lat');
            $table->renameColumn('longitude', 'restaurant_lng');
            $table->renameColumn('status', 'restaurant_status');
            $table->renameColumn('image', 'restaurant_image');
            $table->renameColumn('category_id', 'restaurant_category_id');
            $table->string('restaurant_address_2');
        });
    }
}
