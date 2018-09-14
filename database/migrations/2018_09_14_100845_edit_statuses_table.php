<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statuses', function (Blueprint $table) {
            $table->renameColumn('status_id', 'id');
            $table->string('name_ar')->after('status_name');
            $table->renameColumn('status_name', 'name_en');
            $table->dropColumn('status_comment');
            $table->dropColumn('notify_customer');
            $table->dropColumn('status_for');
            $table->dropColumn('status_color');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statuses', function (Blueprint $table) {
            $table->renameColumn('id', 'status_id');
            $table->text('status_comment');
            $table->tinyInteger('notify_customer');
            $table->string('status_for');
            $table->string('status_color');
        });
    }
}
