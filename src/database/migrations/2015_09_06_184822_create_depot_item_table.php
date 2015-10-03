<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->unsignedInteger('quantity'); // v0.3.2 #35
            // tipo de cantidad
            $table->unsignedInteger('stock_type_id');
            $table->foreign('stock_type_id')
                  ->references('id')
                  ->on('stock_types');
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
