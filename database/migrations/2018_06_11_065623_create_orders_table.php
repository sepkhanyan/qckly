<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->integer('customer_id');
            $table->string('first_name',32);
            $table->string('last_name',32);
            $table->string('email',96);
            $table->string('telephone',32);
            $table->integer('location_id');
            $table->integer('address_id');
            $table->text('cart');
            $table->integer('total_items');
            $table->text('comment');
            $table->string('payment',32);
            $table->string('order_type',32);
            $table->dateTime('date_added');
            $table->date('date_modified');
            $table->time('order_time');
            $table->date('order_date');
            $table->decimal('order_total',15,4);
            $table->integer('status_id');
            $table->string('ip_address',40);
            $table->string('user_agent',255);
            $table->tinyInteger('notify');
            $table->integer('assignee_id');
            $table->integer('invoice_no');
            $table->string('invoice_prefix',32);
            $table->dateTime('invoice_date');
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
        Schema::dropIfExists('orders');
    }
}
