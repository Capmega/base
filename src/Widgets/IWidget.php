<?php
namespace Capmega\Base\Widgets;

/**
 *
 */
interface IWidget
{
    public static function begin(array $options);
    public static function end();
}
