<?php
namespace Capmega\Base\Helpers;

use Route;

class SizeComponent
{
    public $items;
    public $create_url;
    public $delete_url;
    public $csrf_token;
    public $name;
    public $height;
    public $width;
    public $quality;
    public $transparency;
    public $resizing;
    public $add_text;
    public $delete_element;
    public $delete_continue;
    public $delete_cancel;
    public $delete_deleted;
    public $delete_deleted_text;

    public static function generate($items, $route, $id) {

        $object                      = new Self();
        $object->items               = $items;
        $object->create_url          = route($route . '.addsize', ['id' => $id]);
        $object->delete_url          = route($route . '.removesize', ['id' => $id]);
        $object->csrf_token          = csrf_token();
        $object->name                = __('blog::blog.images.name');
        $object->height              = __('blog::blog.images.height');
        $object->width               = __('blog::blog.images.width');
        $object->quality             = __('blog::blog.images.quality');
        $object->transparency        = __('blog::blog.images.transparency');
        $object->resizing            = __('blog::blog.images.resizing');
        $object->add_text            = __('base::messages.add');
        $object->delete_element      = __('base::messages.delete_item');
        $object->delete_continue     = __('base::messages.continue');
        $object->delete_cancel       = __('base::messages.cancel');
        $object->delete_deleted      = __('base::messages.deleted');
        $object->delete_deleted_text = __('base::messages.element_deleted');

        return $object;
    }

    public function render()
    {
        return '<sizes-component
                   :items=\''.$this->items.'\'
                    name="'.$this->name.'"
                    height="'.$this->height.'"
                    width="'.$this->width.'"
                    quality="'.$this->quality.'"
                    transparency="'.$this->transparency.'"
                    resizing="'.$this->resizing.'"
                    add_text="'.$this->add_text.'"
                    create_url="'.$this->create_url.'"
                    delete_url="'.$this->delete_url.'"
                    csrf_token="'.$this->csrf_token.'"
                    delete_element="'.$this->delete_element.'"
                    delete_continue="'.$this->delete_continue.'"
                    delete_cancel="'.$this->delete_cancel.'"
                    delete_deleted="'.$this->delete_deleted.'"
                    delete_deleted_text="'.$this->delete_deleted_text.'"
                ></sizes-component>';
    }

    public function __toString()
    {
        return $this->render();
    }
}
