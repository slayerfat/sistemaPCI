<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); // solicitado por
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('to_user_id')->nullable(); // Dirigido a
            $table->foreign('to_user_id')->references('id')->on('users');
            $table->unsignedInteger('attendant_id');
            $table->foreign('attendant_id')->references('id')->on('attendants');
            $table->unsignedInteger('note_type_id');
            $table->foreign('note_type_id')->references('id')->on('note_types');
            $table->unsignedInteger('petition_id');
            $table->foreign('petition_id')->references('id')->on('petitions');
            $table->date('creation');
            $table->string('comments');
            $table->boolean('status');
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
        Schema::drop('notes');
    }
}
