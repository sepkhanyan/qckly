<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extensions', function (Blueprint $table) {
            $table->increments('extension_id');
            $table->string('type',32)->unique();
            $table->string('name',128)->unique();
            $table->text('data');
            $table->tinyInteger('serialized');
            $table->tinyInteger('status');
            $table->string('title', 255);
            $table->string('version', 11)->default('1.0.0');
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
        Schema::dropIfExists('extensions');
    }
}
