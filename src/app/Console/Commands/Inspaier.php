<?php

namespace PCI\Console\Commands;

use Illuminate\Console\Command;
use PCI\Mamarrachismo\Caimaneitor\Caimaneitor;

class Inspaier extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspirar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muestra un mensaje inspirador.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment(PHP_EOL . Caimaneitor::caimanais() . PHP_EOL);
    }
}
