<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_type_id');
            $table->foreign('item_type_id')
                ->references('id')
                ->on('item_types');
            $table->unsignedInteger('maker_id');
            $table->foreign('maker_id')
                ->references('id')
                ->on('makers');
            $table->unsignedInteger('sub_category_id');
            $table->foreign('sub_category_id')
                ->references('id')
                ->on('sub_categories');
            $table->char('asoc', 1); //ABC
            $table->unsignedInteger('priority'); // 1-100%
            $table->string('desc');
            $table->unsignedInteger('stock');
            $table->unsignedInteger('minimum');
            $table->date('due');
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
        Schema::drop('items');
    }
}
