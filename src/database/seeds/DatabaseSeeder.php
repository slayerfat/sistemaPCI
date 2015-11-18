<?php namespace PCI\Database;

use Config;
use DB;

class DatabaseSeeder extends AbstractTableSeeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("*** Empezando Seeding! ***");

        $this->toggleModelGuard();

        $this->truncateDb();

        $this->call(AuxEntitiesSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(TownSeeder::class);
        $this->call(ParishSeeder::class);
        $this->call(UserRelatedSeeder::class);
        $this->call(ItemSeeder::class);

        $this->toggleModelGuard();

        $this->command->info("*** Seeding terminado! ***");
    }

    /**
     * Genera un truncamiento en todas las tablas de la
     * base de datos del sistema exceptuando las
     * especificadas en el switche.
     *
     * @return void
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
