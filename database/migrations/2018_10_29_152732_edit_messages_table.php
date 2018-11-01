<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->after('message_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->renameColumn('message_id', 'id');
            $table->dropColumn('sender_id');
            $table->dropColumn('date_added');
            $table->dropColumn('send_type');
            $table->dropColumn('recipient');
            $table->dropColumn('subject');
            $table->renameColumn('body', 'message');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->renameColumn('id', 'message_id');
            $table->integer('sender_id');
            $table->dateTime('date_added');
            $table->string('send_type');
            $table->string('recipient');
            $table->text('subject');
            $table->renameColumn('message', 'body');
            $table->tinyInteger('status');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
