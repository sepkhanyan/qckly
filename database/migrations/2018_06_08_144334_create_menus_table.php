<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('menu_id');
            $table->string('menu_name',255);
            $table->text('menu_description');
            $table->decimal('menu_price', 15,4);
            $table->string('menu_photo',255)->nullable();
            $table->integer('menu_category_id');
            $table->integer('stock_qty');
            $table->integer('minimum_qty');
            $table->tinyInteger('subtract_stock');
            $table->tinyInteger('menu_status');
            $table->integer('menu_priority');
            $table->integer('mealtime_id');
            $table->integer('location_id');
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
        Schema::dropIfExists('menus');
    }
}
