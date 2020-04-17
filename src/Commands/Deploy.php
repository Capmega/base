<?php

namespace Capmega\Base\Commands;

use Illuminate\Console\Command;

class Deploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:deploy {target?}
    {--tag= : el branch del cual vas a hacer deploy}
    {--branch= : la rama del cual vas a hacer deploy}
    {--revision= : el commit del cual vas a hacer deploy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hace un deploy completo a un servidor remoto';

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
        $target   = $this->argument('target');
        $command  = 'php vendor/bin/dep deploy ' . $target;

        $tag = $this->option('tag');
        if ($tag) {
            $command .= ' --tag="'.$tag.'"';
        }

        $branch = $this->option('branch');
        if ($branch) {
            $command .= ' --branch="'.$branch.'"';
        }

        $revision = $this->option('revision');
        if ($revision) {
            $command .= ' --revision="'.$revision.'"';
        }

        passthru($command);
        passthru('php vendor/bin/dep fix');
    }
}
