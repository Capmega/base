<?php
namespace Capmega\Base\Widgets\Information;

/**
 *
 */
class Title
{
    public static function generate($params)
    {
        $title  = '<div class="page-title">';
        $title .=   '<h2><span class="la la-'.($params['icon']??'arrow-circle-o-left').'"></span> '.$params['name'].'</h2>';
        $title .= '</div>';
        return $title;
    }
}
