<?php
namespace Capmega\Base\Helpers;

use Route;

class Nav
{
    public $container_class  =  'main-menu menu-fixed menu-dark menu-accordion menu-shadow';
    public $ul_class         =  'navigation navigation-main';
    public $submenu_ul_class =  'menu-content';
    public $active_class     =  'active';
    public $dropdown_class   =  '';
    public $items            = [];
    public $urls             = [];
    public $menu             = '';
    public $current          = '';
    public $options          = [];
    public $element_class    = 'nav-item';


    function __construct($items) {
        $this->items   = $items;
        $this->current = Route::currentRouteName();
    }

    public static function menu(array $items, array $options = [])
    {
        $element          = new static($items);
        $element->options = $options;
        return $element->generateItems();
    }

    protected function generateContainer()
    {
        return '<div class="'.$this->container_class.'" data-scroll-to-active="true">'.
                   '<div class="main-menu-content">'.
                        '<ul class="'.$this->ul_class.'" data-menu="menu-navigation">'.
                            $this->menu.
                        '</ul>'.
                    '</div>'.
                '</div>';
    }

    protected function generateItems()
    {
        foreach ($this->items as $item) {
            if (is_array($item)) {
                $this->menu .= static::generateItem($item);
            }else{
                $this->menu .= static::generateSpecial($item);
            }
        }
        return $this->generateContainer();
    }

    protected function generateSpecial($item)
    {
        switch ($item) {
            default:
                return '';
                break;
        }
    }

    protected function generateSubItems($items)
    {
        $submenu = '<ul class="'.$this->submenu_ul_class.'">';
        foreach ($items as $key => $item) {
            $submenu .= static::generateItem($item, 1);
        }
        return $submenu.'</ul>';
    }

    protected function generateItem($item, $menu_lvl = 0)
    {
        $item['visible'] = $item['visible']??true;
        if (!$item['visible']) {
            return '';
        }
        $this->urls = [];
        $this->getUrls($item);

        if (isset($item['items'])) {
            return $this->generateElement($item, $this->generateSubItems($item['items']), ($item['li_class']??''));
        }
        return $this->generateElement($item, '', $this->element_class . ' ' . ($this->options['submenu_li_class_'. $menu_lvl]??''));

    }

    protected function generateElement($item, $items, $class = ''){
        return '<li class="'.$class.' '.$this->isActive().'">
                    <a class="menu-item" href="'.$this->getRoute($item).'"><i class="la la-'.($item['icon']??'').'"></i>
                    <span class="menu-title">'.$item['name'].'</span>'.$this->generateBadge($item).'</a>
                     '.$items.'
                </li>';
    }

    protected function getRoute($item)
    {
        if (isset($item['url'])) {

            if (is_array($item['url'])) {
                return route($item['url'][0], $item['url'][1]);
            }

            if ($item['url'] == '#') {
                return '#';
            }

            if (substr( $item['url'], 0, 1) === '#') {
                return $item['url'];
            }

            if (substr( $item['url'], 0, 4) === 'http') {
                return $item['url'];
            }

            return route($item['url']);
        }

        return '#';
    }

    protected function generateBadge($item){
        if (isset($item['badge'])) {
            return '<span class="badge badge badge-'.$item['badge']['type'].' badge-pill float-right mr-2">'.$item['badge']['value'].'</span>';
        }
    }

    protected function isActive(){
        if (in_array($this->current, $this->urls)) {
            return $this->active_class;
        }

        foreach ($this->urls as $urls) {
            if (is_array($urls)) {
                if ($this->current == $urls[0]) {
                    foreach (Route::current()->parameters as $key => $parameter) {
                        if ($urls[1] == $parameter) {
                            return $this->active_class;
                        }
                    }
                }
            }
        }

        return '';
    }

    protected function getUrls($item){
        array_push($this->urls, $item['url']??'#');
        $this->getCrudUrls($item);
        $this->getExtraUrls($item);
        if (isset($item['items'])) {
            foreach ($item['items'] as $value) {
                $this->getUrls($value);
            }
        }
    }

    protected function getExtraUrls($item){
        if (isset($item['extra_urls'])) {
            foreach ($item['extra_urls'] as $url) {
                array_push($this->urls, $url);
            }
        }
    }

    protected function getCrudUrls($item){
        if (isset($item['crud'])) {
            array_push($this->urls, $item['crud'].'.create');
            array_push($this->urls, $item['crud'].'.edit');
            array_push($this->urls, $item['crud'].'.show');
        }
    }
}
