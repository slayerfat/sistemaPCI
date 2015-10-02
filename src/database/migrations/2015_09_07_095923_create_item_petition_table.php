<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemPetitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_petition', function (Blueprint $table) {
            $table->unsignedInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items');
            $table->unsignedInteger('petition_id');
            $table->foreign('petition_id')->references('id')->on('petitions');
            $table->unsignedInteger('quantity');
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
        Schema::drop('item_petition');
    }
}
