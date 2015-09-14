<?php namespace PCI\Database;

class TestingSeeder extends AbstractTableSeeder
{

    public function run()
    {
        $this->toggleModelGuard();

        $this->call(AuxEntitiesSeeder::class);

        $this->toggleModelGuard();
    }
}
