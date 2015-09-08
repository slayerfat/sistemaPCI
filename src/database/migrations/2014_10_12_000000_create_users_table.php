<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('profiles');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->boolean('status');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('profiles', function (Blueprint $table) {
            //$table->unsignedInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            //$table->unsignedInteger('updated_by');
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
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropForeign('profiles_created_by_foreign');
            $table->dropForeign('profiles_updated_by_foreign');
            //$table->dropColumn('created_by');
            //$table->dropColumn('updated_by');
        });

        Schema::drop('users');
    }
}
