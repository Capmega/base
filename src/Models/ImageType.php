<?php

namespace Capmega\Base\Models;

use Capmega\Base\Models\ResourceModel;

class ImageType extends ResourceModel
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($params)
    {
        return [
            'name' => 'required'
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
        return unserialize($value);
    }

    /**
     * Custom save
     * @param  array  $options [description]
     */
    public function save(array $options = [])
    {
        $this->generateSeoname();

        parent::save($options);
    }
}
