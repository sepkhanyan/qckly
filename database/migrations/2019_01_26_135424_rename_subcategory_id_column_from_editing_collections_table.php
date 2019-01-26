<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSubcategoryIdColumnFromEditingCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('editing_collections', function (Blueprint $table) {
            $table->dropForeign(['collection_id']);
            $table->dropForeign(['mealtime_id']);
            $table->dropForeign(['service_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('editing_collections', function (Blueprint $table) {
            $table->integer('collection_id')->unsigned()->change();
            $table->foreign('collection_id')
                ->references('id')->on('collections')
                ->onDelete('cascade');
            $table->integer('mealtime_id')->unsigned()->change();
            $table->foreign('mealtime_id')
                ->references('id')->on('mealtimes')
                ->onDelete('cascade');
            $table->integer('service_type_id')->unsigned()->change();
            $table->foreign('service_type_id')
                ->references('id')->on('category_restaurant')
                ->onDelete('cascade');
        });
    }
}
