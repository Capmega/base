<?php

namespace Capmega\Base\Commands;

use Illuminate\Console\Command;

class DeployUnlock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:DeployUnlock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Desbloquea el deploy';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        passthru('php vendor/bin/dep deploy:unlock');
    }
}
