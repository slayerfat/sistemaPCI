<?php

use PCI\Models\User;
use Illuminate\Database\Seeder;

abstract class BaseSeeder extends Seeder
{

    /**
     * El usuario a relacionar con los modelos
     *
     * @param Model
     */
    protected $user;

    /**
     * @uses BaseSeeder::getUser()
     */
    public function __construct()
    {
        $this->user = $this->getUser();
    }

    /**
     * @return User
     */
    protected function getUser()
    {
        $user = User::whereName('tester')
            ->orWhere('name', env('APP_USER'))
            ->firstOrFail();

        return $user;
    }

    /**
     * @param $class
     */
    protected function createDirectory($class)
    {
        $dir = class_basename($class);

        $dir = strtolower($dir);

        // se elimina el directorio de todos los archivos
        Storage::disk('public')->deleteDirectory($dir);
        Storage::disk('public')->makeDirectory($dir);
    }
}
