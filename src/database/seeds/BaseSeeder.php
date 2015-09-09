<?php namespace PCI\Database;

use Storage;
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
     * Obtiene al usuario principal para el seeding,
     * usualmente el tester o lo que sea que este
     * dentro de el archivo .env
     * @return User
     */
    protected function getUser()
    {
        $user = User::whereName('tester')
            ->orWhere('name', env('APP_USER'))
            ->first();

        return $user;
    }

    /**
     * Crea un directorio en la carpeta publica
     * relacionada con el modelo.
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

    /**
     * Genera seeds segun los parametros de data,
     * basicamente itera en un arreglo asociativo y
     * genera seeds para cada entidad o modelo especificado.
     *
     * @see AuxEntitiesSeeder::run()
     * @param $data
     */
    protected function seedModels($data)
    {
        $this->command->comment('Empezando Bucle de ' . __METHOD__);

        foreach ($data as $modelName => $arrays) {
            foreach ($arrays as $array) {
                $this->command->info("Empezando creacion de {$modelName}.");

                $model = new $modelName;

                foreach ($array as $attr => $value) {
                    $model->$attr = $value;
                }

                $model->save();

                $this->command->info("{$modelName} terminado.");
            }
        }

        $this->command->comment('Terminado Bucle de ' . __METHOD__);
    }
}
