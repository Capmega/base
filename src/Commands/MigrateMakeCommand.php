<?php

namespace Capmega\Base\Commands;

use Illuminate\Database\Console\Migrations\MigrateMakeCommand as BaseCommand;
use Capmega\Base\Builder\BaseMigrationCreator;
use Illuminate\Support\Str;
use Illuminate\Support\Composer;
use Illuminate\Database\Migrations\MigrationCreator;

class MigrateMakeCommand extends BaseCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:migration-sdk {name : The name of the migration}
        {--create= : The table to be created}
        {--table= : The table to migrate}
        {--path= : The location where the migration file should be created}
        {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
        {--fullpath : Output the full path of the migration}';

    /**
     * Create a new migration install command instance.
     *
     * @param  \Illuminate\Database\Migrations\MigrationCreator  $creator
     * @param  \Illuminate\Support\Composer  $composer
     * @return void
     */
    public function __construct(BaseMigrationCreator $creator, Composer $composer)
    {
        parent::__construct($creator, $composer);
    }
}
