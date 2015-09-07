<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_id');
            $table->foreign('department_id')
                ->references('id')
                ->on('departments');
            $table->unsignedInteger('position_id')->nullable();
            $table->foreign('position_id')
                ->references('id')
                ->on('positions');
            $table->unsignedInteger('employee_id');
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees');
            $table->date('join_date')->nullable();
            $table->date('departure_date')->nullable();
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
        Schema::drop('work_details');
    }
}
