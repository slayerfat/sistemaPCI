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
            $table->string('name', 20)->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->boolean('status');
            $table->string('confirmation_code', 32)->nullable();
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
        $profiles = [
            'Administrador',
            'Usuario',
            'Desactivado',
        ];

        foreach ($profiles as $profile) {
            $obj = new Profile;

            $obj->desc       = $profile;
            $obj->created_by = 1;
            $obj->updated_by = 1;

            $obj->save();
        }

        $user = new User;

        $user->name       = env('APP_USER');
        $user->email      = env('APP_USER_EMAIL');
        $user->password   = bcrypt(env('APP_USER_PASSWORD'));
        $user->created_by = 1;
        $user->updated_by = 1;
        $user->profile_id = 1;

        $user->save();
    }
}
