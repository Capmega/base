<?php
namespace Capmega\Base\Widgets;

/**
 *
 */
abstract class Widget
{

    abstract public static function generate(array $params);

    abstract protected function generateWrap();

    public function __toString()
    {
        return $this->generateWrap();
    }
}
