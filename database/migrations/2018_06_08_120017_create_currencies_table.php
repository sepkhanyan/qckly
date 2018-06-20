<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('currency_id');
            $table->integer('country_id');
            $table->string('currency_name', 32);
            $table->string('country_code', 3);
            $table->string('country_symbol', 3);
            $table->decimal('currency_rate', 15, 8);
            $table->tinyInteger('symbol_position');
            $table->char('thousand_sign', 1);
            $table->char('decimal_sign', 1);
            $table->char('decimal_position', 1);
            $table->string('iso_alpha2', 2);
            $table->string('iso_alpha3', 3);
            $table->integer('iso_numeric');
            $table->string('flag', 6);
            $table->integer('currency_status');
            $table->dateTime('date_modified');
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
        Schema::dropIfExists('currencies');
    }
}
