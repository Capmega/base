<?php

namespace Capmega\Base\Commands;

use Illuminate\Console\Command;

class ConverImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:images {id?} {--type} {--blog=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera imagenes optimizadas';

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
        $id   = $this->argument('id');
        $blog = $this->option('blog');
        $type = $this->option('type');
    }
}
