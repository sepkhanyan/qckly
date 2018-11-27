<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditingCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('editing_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('collection_id');
            $table->foreign('collection_id')
                ->references('id')->on('collections')
                ->onDelete('cascade');
            $table->tinyInteger('is_available');
            $table->float('price')->nullable();
            $table->string('name_en');
            $table->string('name_ar');
            $table->text('service_provide_en');
            $table->text('service_provide_ar');
            $table->integer('setup_time')->nullable();
            $table->integer('max_time')->nullable();
            $table->text('requirements_en')->nullable();
            $table->text('requirements_ar')->nullable();
            $table->text('service_presentation_en');
            $table->text('service_presentation_ar');
            $table->text('description_en');
            $table->text('description_ar');
            $table->unsignedInteger('mealtime_id');
            $table->foreign('mealtime_id')
                ->references('id')->on('mealtimes')
                ->onDelete('cascade');
            $table->integer('max_qty')->nullable();
            $table->integer('min_qty')->nullable();
            $table->integer('persons_max_count')->nullable();
            $table->tinyInteger('allow_person_increase')->nullable();
            $table->integer('min_serve_to_person')->nullable();
            $table->integer('max_serve_to_person')->nullable();
            $table->tinyInteger('female_caterer_available')->default(0);
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
        Schema::dropIfExists('editing_collections');
    }
}
