<?php
namespace Capmega\Base\Widgets\Html;

/**
 *
 */
class BreadCrumb
{
    public static function generate($params = [])
    {
        $params['screen_background']  = $params['screen_background']??'black';
        $params['screen_color']       = $params['screen_color']??'red';
        $params['screen_text_align']  = $params['screen_text_align']??'center';
        $params['screen_style_extra'] = $params['screen_style_extra']??'';
        $params['extra']              = $params['extra']??'';

        $preload  = '<div id="loader-screen" style="position:fixed;top:0px;bottom:0px;left:0px;right:0px;z-index:2147483647;display:block;background:'.$params['screen_background'].';color: '.$params['screen_color'].';text-align: '.$params['screen_text_align'].';'.$params['extra'].'" '.$params['screen_style_extra'].'>';

        switch($params['transition_style']){
            case 'fade':
                if($params['page_selector']){
                    $html .= html_script('$("'.$params['page_selector'].'").show('.$params['transition_time'].');
                                          $("#loader-screen").fadeOut('.$params['transition_time'].', function(){ $("#loader-screen").css("display", "none"); '.($params['screen_remove'] ? '$("#loader-screen").remove();' : '').' });');

                    return $html;
                }

                /*
                 * Only hide the loader screen
                 */
                $html .= html_script('$("#loader-screen").fadeOut('.$params['transition_time'].', function(){ $("#loader-screen").css("display", "none"); '.($params['screen_remove'] ? '$("#loader-screen").remove();' : '').' });');
                break;

            case 'slide':
                $html .= html_script('var height = $("#loader-screen").height(); $("#loader-screen").animate({ top: height }, '.$params['transition_time'].', function(){ $("#loader-screen").css("display", "none"); '.($params['screen_remove'] ? '$("#loader-screen").remove();' : '').' });');
                break;

            default:
                $html .= html_script('var height = $("#loader-screen").height(); $("#loader-screen").animate({ top: height }, '.$params['transition_time'].', function(){ $("#loader-screen").css("display", "none"); '.($params['screen_remove'] ? '$("#loader-screen").remove();' : '').' });');
        }
        return $preload;
    }
}
