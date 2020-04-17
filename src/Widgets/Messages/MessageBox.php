<?php
namespace Capmega\Base\Widgets\Messages;

/**
 *
 */
class MessageBox
{
    public static function generate($errors)
    {
        $message = '';
        if ($errors->any()){
            $message =  '<div class="alert alert-danger">'.
                           '<ul>';
                           foreach ($errors->all() as $error) {
                               $message .= '<li>'.htmlspecialchars($error).'</li>';
                           }
            $message .=    '</ul>'.
                        '</div>';
        }
        return $message;
    }
}
