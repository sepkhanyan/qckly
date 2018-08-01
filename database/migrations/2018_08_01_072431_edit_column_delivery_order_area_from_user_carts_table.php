<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnDeliveryOrderAreaFromUserCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_carts', function (Blueprint $table) {
            $table->integer('delivery_order_area')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_carts', function (Blueprint $table) {
            $table->string('delivery_order_area')->change();
        });
    }
}
