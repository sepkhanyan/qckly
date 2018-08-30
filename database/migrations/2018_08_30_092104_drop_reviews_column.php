<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropReviewsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('reviews');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('review_id');
            $table->integer('customer_id');
            $table->integer('sale_id');
            $table->string('sale_type',32);
            $table->string('author',32);
            $table->integer('location_id');
            $table->integer('quality');
            $table->integer('delivery');
            $table->integer('service');
            $table->text('review_text');
            $table->dateTime('date_added');
            $table->tinyInteger('review');
            $table->timestamps();
        });
    }
}
