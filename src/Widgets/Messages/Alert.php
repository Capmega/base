<?php
namespace Capmega\Base\Widgets\Messages;

/**
 *
 */
class Alert
{
    public static function generate($message = 'success', $type = 'success')
    {
        if (session($message)){
            return '<div class="alert alert-success">'.
                        htmlspecialchars(session($message)).
                    '</div>';
        }
    }
}
