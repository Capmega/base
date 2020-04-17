<?php

namespace Capmega\Base\Builder;

use Illuminate\Database\Migrations\MigrationCreator;

class BaseMigrationCreator extends MigrationCreator
{
    /**
     * Get the path to the stubs.
     *
     * @return string
     */
    public function stubPath()
    {
        return __DIR__ . '/../../resources/stubs';
    }
}
