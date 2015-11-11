<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemMovements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('stock_id');
            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->unsignedInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->unsignedInteger('movement_id');
            $table->foreign('movement_id')->references('id')->on('movements');
            $table->float('quantity', 16, 7)->nullable();
            $table->date('due')->nullable()->index();
            // tipo de cantidad
            $table->unsignedInteger('stock_type_id');
            $table->foreign('stock_type_id')
                  ->references('id')
                  ->on('stock_types');
            $table->timestamps();
            $table->unsignedInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('itemMovements');
    }
}
