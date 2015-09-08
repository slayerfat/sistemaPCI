<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("*** Empezando Migracion! ***");

        Model::unguard();

        $this->truncateDb();

        // $this->call(UserTableSeeder::class);

        Model::reguard();

        $this->command->info("*** Migracion terminada! ***");
    }

    protected function truncateDb()
    {
        $this->command->info("--- truncating! ---");

        // Truncate all tables, except migrations
        $tables = \DB::select('SHOW TABLES');

        $tablesInDb = "Tables_in_" . \Config::get('database.connections.mysql.database');

        // desactiva impedimento de foreign keys
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            switch ($table->$tablesInDb) {
                case 'migrations':
                case 'profiles':
                case 'users':
                    break;
                default:
                    \DB::table($table->Tables_in_orbiagro)->truncate();
                    break;
            }
        }

        // reactiva impedimento (no se si sea necesario)
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        $this->command->info("--- truncate completado ---");
    }
}
