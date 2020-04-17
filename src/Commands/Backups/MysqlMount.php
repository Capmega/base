<?php

namespace Capmega\Base\Commands\Backups;

use Illuminate\Console\Command;

class MysqlMount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:MysqlMount {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'monta un respaldo';

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
        $name = $this->argument('name');
        $this->info('Montando respaldo');
        //$path = 'storage/temp/' . config('database.connections.mysql.database') . '-' . date('Y_m_d_h_i_s') . '.sql';
        $path = storage_path() . '/temp/' . $name . '.sql';
        shell_exec('mysql -u ' . config('database.connections.mysql.username') . ' -p' . config('database.connections.mysql.password') . ' ' . config('database.connections.mysql.database') . ' < ' . $path);
    }
}
