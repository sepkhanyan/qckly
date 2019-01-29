<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditingCollectionServiceTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_collection_service_type', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('editing_collection_id');
            $table->foreign('editing_collection_id')
                ->references('id')->on('editing_collections')
                ->onDelete('cascade');
            $table->integer('service_type_id');
            $table->string('name_en');
            $table->string('name_ar');
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
        Schema::dropIfExists('editing_collection_service_type');
    }
}
