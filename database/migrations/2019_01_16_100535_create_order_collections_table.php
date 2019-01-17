<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade');
            $table->integer('restaurant_id');
            $table->string('restaurant_en');
            $table->string('restaurant_ar');
            $table->integer('collection_id');
            $table->string('collection_en');
            $table->string('collection_ar');
            $table->integer('collection_category_id');
            $table->string('collection_category_en');
            $table->string('collection_category_ar');
            $table->float('collection_price')->nullable();
            $table->float('subtotal');
            $table->tinyInteger('female_caterer');
            $table->text('special_instruction');
            $table->integer('service_type_id');
            $table->string('service_type_en');
            $table->string('service_type_ar');
            $table->integer('quantity')->nullable();
            $table->integer('persons_count')->nullable();
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
        Schema::dropIfExists('order_collections');
    }
}
