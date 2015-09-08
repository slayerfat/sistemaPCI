<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use PCI\Models\Profile;
use PCI\Models\User;

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
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
        });

        $this->createInitialSeed();

        Schema::table('profiles', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users');
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
        });

        Schema::drop('users');
    }

    /**
     * Genera el primer perfil y usuario en el sistema,
     * (necesario para created/updated)
     */
    private function createInitialSeed()
    {
        $profile = factory(PCI\Models\Profile::class)->make(['desc' => 'Administrador']);

        $profile->created_by = 1;
        $profile->updated_by = 1;
        $profile->save();

        $user = new User;

        $user->name       = env('APP_USER');
        $user->email      = env('APP_USER_EMAIL');
        $user->password   = bcrypt(env('APP_USER_PASSWORD'));
        $user->created_by = 1;
        $user->updated_by = 1;

        $profile->users()->save($user);
    }
}
