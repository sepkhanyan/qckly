<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_groups', function (Blueprint $table) {
            $table->increments('staff_group_id');
            $table->string('staff_group_name',32);
            $table->tinyInteger('customer_account_access');
            $table->tinyInteger('location_access');
            $table->text('permission');
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
        Schema::dropIfExists('staff_groups');
    }
}
