<?php namespace PCI\Database;

/**
 * Class TestingSeeder
 * @package PCI\Database
 * @author Alejandro Granadillo <slayerfat@gmail.com>
 * @link https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
class TestingSeeder extends AbstractTableSeeder
{

    public function run()
    {
        $this->toggleModelGuard();

        $this->call(AuxEntitiesSeeder::class);

        $this->toggleModelGuard();
    }
}
