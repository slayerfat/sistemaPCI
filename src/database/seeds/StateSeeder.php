<?php namespace PCI\Database;

use DB;

class StateSeeder extends AbstractSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->comment('Empezando ' . __CLASS__);

        DB::statement(
            "INSERT INTO states
            (id, `desc`, created_at, updated_at, created_by, updated_by)
            VALUES
            (1, 'Distrito Capital', current_timestamp, current_timestamp, 1, 1),
            (2, 'Anzoátegui'      , current_timestamp, current_timestamp, 1, 1),
            (3, 'Amazonas'        , current_timestamp, current_timestamp, 1, 1),
            (4, 'Apure'           , current_timestamp, current_timestamp, 1, 1),
            (5, 'Aragua'          , current_timestamp, current_timestamp, 1, 1),
            (6, 'Barinas'         , current_timestamp, current_timestamp, 1, 1),
            (7, 'Bolívar'         , current_timestamp, current_timestamp, 1, 1),
            (8, 'Carabobo'        , current_timestamp, current_timestamp, 1, 1),
            (9, 'Cojedes'         , current_timestamp, current_timestamp, 1, 1),
            (10, 'Delta Amacuro'  , current_timestamp, current_timestamp, 1, 1),
            (11, 'Falcón'         , current_timestamp, current_timestamp, 1, 1),
            (12, 'Guárico'        , current_timestamp, current_timestamp, 1, 1),
            (13, 'Lara'           , current_timestamp, current_timestamp, 1, 1),
            (14, 'Mérida'         , current_timestamp, current_timestamp, 1, 1),
            (15, 'Miranda'        , current_timestamp, current_timestamp, 1, 1),
            (16, 'Monagas'        , current_timestamp, current_timestamp, 1, 1),
            (17, 'Nueva Esparta'  , current_timestamp, current_timestamp, 1, 1),
            (18, 'Portuguesa'     , current_timestamp, current_timestamp, 1, 1),
            (19, 'Sucre'          , current_timestamp, current_timestamp, 1, 1),
            (20, 'Táchira'        , current_timestamp, current_timestamp, 1, 1),
            (21, 'Trujillo'       , current_timestamp, current_timestamp, 1, 1),
            (22, 'Yaracuy'        , current_timestamp, current_timestamp, 1, 1),
            (23, 'Vargas'         , current_timestamp, current_timestamp, 1, 1),
            (24, 'Zulia'          , current_timestamp, current_timestamp, 1, 1);"
        );
    }
}
