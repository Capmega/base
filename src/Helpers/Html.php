<?php
namespace Capmega\Base\Helpers;

use Request;

/**
 *
 */
class Html
{

    public static function favicon($mstitle = '#ffffff', $theme_color = '#ffffff')
    {
        return '<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
                <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
                <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
                <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
                <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
                <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
                <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
                <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
                <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
                <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
                <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
                <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
                <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
                <link rel="manifest" href="/manifest.json">
                <meta name="msapplication-TileColor" content="'.$mstitle.'">
                <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
                <meta name="theme-color" content="'.$theme_color.'">';
    }

    public static function getValue($model, $attribute){
        return $model->id ? $model->$attribute :old($attribute);
    }

    public static function generateLabel($model, $attribute, $options = [])
    {
        if (isset($options['label']) && $options['label'] == false) {
            return '';
        }
        return '<label>'.$model->getLabel($attribute).'</label>';
    }

    public static function generateAttributes($options)
    {
        $attributes = '';
        foreach ($options['html'] as $key => $attribute) {
            $attributes .= $key.'="'.$attribute.'"';
        }
        return $attributes;
    }

    public static function getAttributeErrors($erros, $options = [])
    {
        if ($erros) {
            $error = '<div class="help-block"><ul role="alert" class="text-danger">';
            foreach ($erros as $message) {
                $error .= '<li>'.htmlspecialchars($message).'</li>';
            }
            return $error.'</ul></div>';
        }
    }

    public static function startTag($tag, $options)
    {
        return '<'.$tag.' '.Html::setAttributes($options).'>';
    }

    public static function endTag($tag)
    {
        return '</'.$tag.'>';
    }

    public static function setAttributes($options)
    {
        $attributes = '';
        foreach ($options as $key => $attribute) {
            $attributes .= $key.'="'.$attribute.'"';
        }
        return $attributes;
    }

    /**
     * Get html tag for one image.
     * @param  string $src         the url or route for one image
     * @param  array  $options     specified options form height, width and alt.
     * @param  array  $htmlOptions extra html options like class, style, etc.
     * @return string              html tag for one image.
     */
    public static function image($src, $htmlOptions = [], $options = [])
    {
        $options['lazy']       = $options['lazy']?? '';
        $htmlOptions['height'] = $htmlOptions['height']?? '';
        $htmlOptions['width']  = $htmlOptions['width']?? '';
        $htmlOptions['alt']    = $htmlOptions['alt']?? '';

        if (strpos($src, 'http') === false) {
            $size = getimagesize($src);
            if (empty($htmlOptions['height']) OR empty($htmlOptions['width'])) {
                $htmlOptions['height'] = $size[0];
                $htmlOptions['width']  = $size[1];
            }else {
                if ($htmlOptions['height'] < $size[0] or $htmlOptions['width'] < $size[1]) {
                    //resize to new size, some day i'll do
                }
            }

            $src  = asset($src);
        }

        if (strpos(\Request::server('HTTP_ACCEPT'), 'webp') !== false) {
            $src = \str_replace(['.jpg', '.jpeg', '.png'], '.webp', $src);
        }

        if ($options['lazy']) {
            $options['preload'] = $options['preload']??'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAoMBgDTD2qgAAAAASUVORK5CYII=';
            return '<img src="'.$options['preload'].'" data-src="'.$src.'" '.Self::setAttributes($htmlOptions).' class="lazy">';
        }

        return '<img src="'.$src.'" '.Self::setAttributes($htmlOptions).' >';
    }

}
