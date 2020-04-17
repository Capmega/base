<?php
namespace Capmega\Base\Helpers;

/**
*
*/
class Command
{

    public static function execute_command($command, $verbose = false)
    {
        if ($verbose) {
            dump($command);
        }
        shell_exec($command);
    }
}

?>
