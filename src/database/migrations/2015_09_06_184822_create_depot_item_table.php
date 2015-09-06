<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepotItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depot_item', function (Blueprint $table) {
            $table->unsignedInteger('depot_id');
            $table->foreign('depot_id')
                ->references('id')
                ->on('depots');
            $table->unsignedInteger('item_id');
            $table->foreign('item_id')
                ->references('id')
                ->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('depot_item');
    }
}
