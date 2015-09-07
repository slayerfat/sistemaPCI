<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_item', function (Blueprint $table) {
            $table->unsignedInteger('item_id');
            $table->foreign('item_id')
                ->references('id')
                ->on('items');
            $table->unsignedInteger('depends_on_id');
            $table->foreign('depends_on_id')
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
        Schema::drop('item_item');
    }
}
