<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->unsignedInteger('address_id');
            $table->foreign('address_id')
                ->references('id')
                ->on('addresses');
            $table->unsignedInteger('nationality_id');
            $table->foreign('nationality_id')
                ->references('id')
                ->on('nationalities');
            $table->unsignedInteger('gender_id');
            $table->foreign('gender_id')
                ->references('id')
                ->on('genders');
            $table->unsignedInteger('ci')->unique()->index();
            $table->string('first_name', 20);
            $table->string('last_name', 20)->nullable();
            $table->string('first_surname', 20);
            $table->string('last_surname', 20)->nullable();
            /**
             * numero telefonico: 9999 0212 1112233
             * el 0000 es el codigo internacional
             * Venezuela es 0058
             */
            $table->string('phone', 15)->nullable();
            $table->string('cellphone', 15)->nullable();
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
        Schema::drop('user_details');
    }
}
