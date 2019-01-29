<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddServiceTypeIdColumnToUserCartCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_cart_collections', function (Blueprint $table) {
            $table->integer('service_type_id')->after('female_caterer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_cart_collections', function (Blueprint $table) {
            $table->dropColumn('service_type_id');
        });
    }
}
