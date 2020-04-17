<?php

namespace Capmega\Base\Commands\Backups;

use Illuminate\Console\Command;

class SendToServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:SendToServer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia la DB y archivos al servidor';

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
        if ($this->confirm('¿Esto mandara tus cambios locales al servidor estas seguro de continuar?')) {
            $name = config('database.connections.mysql.database');
            $this->info('Syncronizando Carpetas del servidor');

            foreach (config('base.sync.sync_folders') as $folder) {
                $this->info('Syncronizando ' . $folder);
                shell_exec('rsync -avz -e "ssh -p '.config('base.sync.port').'" ' . $folder . ' ' . $this->getServer() . ':' . config('base.sync.path') . '/' . $folder);
            }

            $this->info('Generando resplado Mysql');
            $path = 'storage/temp/' . $name . '.sql';
            shell_exec('mysqldump -u ' . config('database.connections.mysql.username') . ' -p' . config('database.connections.mysql.password') . ' ' . $name . ' > ' . $path);

            $this->info('Copiando al servidor el resplado Mysql');
            shell_exec('rsync -avz -e "ssh -p '.config('base.sync.port').'" ' . ' ' . $path . ' ' . $this->getServer() . ':' . config('base.sync.path') . '/' . $path);

            $this->info('Montando resplado Mysql');
            shell_exec('ssh -p ' . config('base.sync.port').' ' . $this->getServer() . ' "php ' . config('base.sync.path') . '/artisan sdk:MysqlMount ' . $name . '"');
        }

    }

    private function getServer()
    {
        if (config('base.sync.username')) {
            return config('base.sync.username') . '@' . config('base.sync.server');
        }
        return '';
    }
}
