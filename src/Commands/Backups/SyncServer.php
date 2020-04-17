<?php

namespace Capmega\Base\Commands\Backups;

use Illuminate\Console\Command;
use Capmega\Base\Helpers\Command as CCommand;

class SyncServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:SyncServer {--V : Verbose Mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncroniza el servidor remoto con el local';

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
        $name    = config('database.connections.mysql.database');
        $verbose = $this->option('V');

        $this->info('Syncronizando Carpetas');
        foreach (config('base.sync.sync_folders') as $folder) {
            $this->info('Syncronizando ' . $folder);
            CCommand::execute_command('rsync -avz -e "ssh -p '.config('base.sync.port').'" ' . $this->getServer() . ':' . config('base.sync.path') . '/' . $folder . ' ' . $folder, $verbose);
        }

        $this->info('Generando resplado Mysql');
        CCommand::execute_command('ssh -p ' . config('base.sync.port').' ' . $this->getServer() . ' "php ' . config('base.sync.path') . '/artisan sdk:MysqlBackup ' . $name . '"', $verbose);

        $this->info('Copiando a local el resplado Mysql');
        $path = 'storage/temp/' . $name . '.sql';
        CCommand::execute_command('rsync -avz -e "ssh -p '.config('base.sync.port').'" ' . $this->getServer() . ':' . config('base.sync.path') . '/' . $path . ' ' . $path, $verbose);

        $this->info('Montando resplado Mysql');
        CCommand::execute_command('mysql -u ' . config('database.connections.mysql.username') . ' -p' . config('database.connections.mysql.password') . ' ' . $name . ' < ' . $path, $verbose);
    }

    private function getServer()
    {
        if (config('base.sync.username')) {
            return config('base.sync.username') . '@' . config('base.sync.server');
        }
        return '';
    }
}
