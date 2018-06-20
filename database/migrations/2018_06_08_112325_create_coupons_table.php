<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('coupon_id');
            $table->string('name', 128);
            $table->string('code', 15);
            $table->char('type', 1);
            $table->decimal('discount', 15,4);
            $table->decimal('min_total', 15,4);
            $table->integer('redemptions')->default(0);
            $table->integer('customer_redemption')->default(0);
            $table->text('description');
            $table->tinyInteger('status');
            $table->date('date_added');
            $table->char('validity', 15);
            $table->date('fixed_date')->nullable();
            $table->time('fixed_from_time')->nullable();
            $table->time('fixed_to_time')->nullable();
            $table->date('period_start_date')->nullable();
            $table->date('period_end_date')->nullable();
            $table->string('recurring_every', 35);
            $table->time('recurring_from_time')->nullable();
            $table->time('recurring_to_time')->nullable();
            $table->tinyInteger('order_restriction');
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
        Schema::dropIfExists('coupons');
    }
}
