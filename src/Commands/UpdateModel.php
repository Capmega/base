<?php

namespace Capmega\Base\Commands;

use Illuminate\Console\Command;
use Schema;

class UpdateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdk:update-model {model : Model to update}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Añade las relaciones y validaciones conforma a la base de datos';

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
        $model      = $this->argument('model');
        $model      = new $model();
        $table      = $model->getTable();
        $attributes = Schema::getColumnListing($table);

        foreach ($attributes as $key => $value) {
            dump(Schema::getColumnType($table, $value));

            //SHOW CREATE TABLE `blogs`;

            /*
            SELECT
              TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
            FROM
              INFORMATION_SCHEMA.KEY_COLUMN_USAGE
            WHERE
              REFERENCED_TABLE_SCHEMA = 'sdk_template' AND
              REFERENCED_TABLE_NAME = 'blogs';

             */
        }
        dd($attributes);
    }
}
