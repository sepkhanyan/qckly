<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditAddressColumnFromRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->string('address_en')->nullable()->change();
            $table->string('address_ar')->nullable()->change();
            $table->string('postcode')->nullable()->change();
            $table->float('latitude')->nullable()->change();
            $table->float('longitude')->nullable()->change();
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
            $table->string('address_en')->nullable(false)->change();
            $table->string('address_ar')->nullable(false)->change();
            $table->string('postcode')->nullable(false)->change();
            $table->float('latitude')->nullable(false)->change();
            $table->float('longitude')->nullable(false)->change();
        });
    }
}
