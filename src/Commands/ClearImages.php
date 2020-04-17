<?php

namespace Capmega\Base\Commands;

use Illuminate\Console\Command;
use Capmega\Blog\Models\BlogImage;

class ClearImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:images {id?} {--type} {--blog=} {--delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina imagenes';

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

        $image = BlogImage::find($id);
    }
}
