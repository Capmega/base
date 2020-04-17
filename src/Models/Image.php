<?php

namespace Capmega\Base\Models;

use Capmega\Base\Models\ResourceModel;
use Capmega\Base\Helpers\{Images, Html};

class Image extends ResourceModel
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($params)
    {
        return [
            'alt'   => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ];
    }

    /**
     * Get client attributes values.
     *
     * @return array
     */
    public function attributes()
    {
        $attributes = parent::attributes();
        return array_merge($attributes, [
            'image_types_id' => __('base::attributes.images.image_types_id'),
            'route'          => __('base::attributes.images.route'),
            'alt'            => __('base::attributes.images.alt'),
        ]);
    }

    /**
     * Get attributes for search.
     *
     * @return array
     */
    public function getFiltersAttribute()
    {
        $attributes = parent::getFiltersAttribute();
        return array_merge([
        ], $attributes);
    }

    public function getSizesAttribute($value)
    {
        if (!$value) {
            return [];
        }
        return unserialize($value);
    }

    public function removeImage($rm_original = true)
    {
        Images::removeImage('images/'. $this->route, $this->id, $this->extension, $rm_original);
    }

    public function convertImage()
    {
        Images::convertImage('images/' . $this->route, $this->seoname, $this->extension, $this->getSizes());
    }

    public function getImage($size = 'medium', $htmlOptions = [], $options = [])
    {
        return Html::image(
            'storage/'.'images/'. $this->route.$this->seoname.'-'.$size.'.jpg',
            array_merge($htmlOptions, ['alt' => $this->alt]),
            $options
        );
    }

    public function save(array $options = [])
    {
        $this->generateSeoname();

        parent::save($options);

    }

    public function getSizes()
    {
        if ($this->image_types_id) {
            return $this->imageType->sizes;
        }

        return $this->sizes;
    }

    /**
     * Devuelve el usuario que creo el elemento
     * @return [type] [description]
     */
    public function imageType()
    {
        return $this->hasOne('Capmega\Base\Models\ImageType', 'id', 'image_types_id');
    }
}
