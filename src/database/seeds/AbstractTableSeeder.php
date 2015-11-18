<?php namespace PCI\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class AbstractTableSeeder
 *
 * @package PCI\Database
 * @author  Alejandro Granadillo <slayerfat@gmail.com>
 * @link    https://github.com/slayerfat/sistemaPCI Repositorio en linea.
 */
abstract class AbstractTableSeeder extends Seeder
{

    protected $guarded;

    public function __construct()
    {
        $this->guarded = true;
    }

    protected function toggleModelGuard()
    {
        $this->guarded ? Model::unguard() : Model::reguard();

        return $this->guarded = !$this->guarded;
    }
}
