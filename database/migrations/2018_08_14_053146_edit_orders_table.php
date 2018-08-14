<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('order_id');
            $table->integer('cart_id')->after('customer_id');
            $table->integer('payment_type')->after('cart_id');
            $table->float('total_price')->after('payment_type');
            $table->renameColumn('order_id', 'id');
            $table->renameColumn('customer_id', 'user_id');
            $table->dropColumn('first_name');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('email');
            $table->dropColumn('telephone');
            $table->dropColumn('location_id');
            $table->dropColumn('address_id');
            $table->dropColumn('cart');
            $table->dropColumn('total_items');
            $table->dropColumn('comment');
            $table->dropColumn('payment');
            $table->dropColumn('order_type');
            $table->dropColumn('date_added');
            $table->dropColumn('date_modified');
            $table->dropColumn('order_time');
            $table->dropColumn('order_date');
            $table->dropColumn('order_total');
            $table->dropColumn('status_id');
            $table->dropColumn('ip_address');
            $table->dropColumn('user_agent');
            $table->dropColumn('notify');
            $table->dropColumn('assignee_id');
            $table->dropColumn('invoice_no');
            $table->dropColumn('invoice_prefix');
            $table->dropColumn('invoice_date');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('id', 'order_id');
            $table->renameColumn('user_id', 'customer_id');
            $table->dropColumn('transaction_id');
            $table->dropColumn('cart_id');
            $table->dropColumn('payment_type');
            $table->dropColumn('total_price');
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
        });
    }
}
