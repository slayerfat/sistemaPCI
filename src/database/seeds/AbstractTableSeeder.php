<?php namespace PCI\Database;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

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

        return $this->guarded = ! $this->guarded;
    }
}
