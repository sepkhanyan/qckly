<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionUnavailabilityHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_unavailability_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('weekday')->nullable();
            $table->time('start_time')->default('00:00:00');
            $table->time('end_time')->default('00:00:00');
            $table->tinyInteger('status');
            $table->unsignedInteger('collection_id');
            $table->foreign('collection_id')
                ->references('id')->on('collections')
                ->onDelete('cascade');
            $table->string('type');
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
        Schema::dropIfExists('collection_unavailability_hours');
    }
}
