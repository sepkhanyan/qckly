<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusSpecialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus_specials', function (Blueprint $table) {
            $table->increments('special_id');
            $table->integer('menu_id')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('special_prise', 15, 4);
            $table->tinyInteger('special_status');
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
        Schema::dropIfExists('menus_specials');
    }
}
