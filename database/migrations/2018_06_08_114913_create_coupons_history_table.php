<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons_history', function (Blueprint $table) {
            $table->increments('coupon_history_id');
            $table->integer('coupon_id');
            $table->integer('order_id');
            $table->integer('customer_id');
            $table->string('code', 15);
            $table->decimal('min_total', 15, 4);
            $table->decimal('amount', 15, 4);
            $table->dateTime('date_used');
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons_history');
    }
}
