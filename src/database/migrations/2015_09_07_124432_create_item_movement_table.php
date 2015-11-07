<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemMovementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_movement', function (Blueprint $table) {
            $table->unsignedInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->unsignedInteger('movement_id');
            $table->foreign('movement_id')->references('id')->on('movements');
            $table->float('quantity', 16, 7)->nullable();
            $table->date('due')->nullable();
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
        Schema::drop('item_movement');
    }
}
