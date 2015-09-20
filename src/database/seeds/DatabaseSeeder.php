<?php namespace PCI\Database;

use DB;
use Config;

class DatabaseSeeder extends AbstractTableSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("*** Empezando Migracion! ***");

        $this->toggleModelGuard();

        $this->truncateDb();

        $this->call(AuxEntitiesSeederAbstract::class);
        $this->call(StateSeederAbstract::class);
        $this->call(TownSeederAbstract::class);
        $this->call(ParishSeederAbstract::class);
        $this->call(UserRelatedSeederAbstract::class);
        $this->call(ItemSeederAbstract::class);

        $this->toggleModelGuard();

        $this->command->info("*** Migracion terminada! ***");
    }

    /**
     * Genera un truncamiento (eliminacion de datos) en todas las tablas
     * de la base de datos del sistema exceptuando las especificadas en el switche
     */
    protected function truncateDb()
    {
        $this->command->info("--- truncating! ---");

        // Truncate all tables, except migrations
        $tables = DB::select('SHOW TABLES');

        $tablesInDb = "Tables_in_" . Config::get('database.connections.mysql.database');

        // desactiva impedimento de foreign keys
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            switch ($table->$tablesInDb) {
                case 'migrations':
                case 'profiles':
                case 'users':
                    break;
                default:
                    DB::table($table->Tables_in_sistemaPCI)->truncate();
                    break;
            }
        }

        // reactiva impedimento (no se si sea necesario)
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        $this->command->info("--- truncate completado ---");
    }
}
