<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStreetNumberFieldToAddressesTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('street_number')->after('location');
        });
        Schema::table('delivery_addresses', function (Blueprint $table) {
            $table->string('street_number')->after('location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn('street_number');
        });
        Schema::table('delivery_addresses', function (Blueprint $table) {
            $table->dropColumn('street_number');
        });
    }
}
