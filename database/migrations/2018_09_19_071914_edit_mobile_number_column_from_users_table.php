<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditMobileNumberColumnFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('country_code')->nullable()->change();
            $table->integer('mobile_number')->nullable()->change();
            $table->integer('otp')->nullable()->change();
            $table->string('lang')->default('en')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('country_code')->nullable(false)->change();
            $table->integer('mobile_number')->nullable(false)->change();
            $table->integer('otp')->nullable(false)->change();
            $table->string('lang')->default('en')->nullable(false)->change();
        });
    }
}
