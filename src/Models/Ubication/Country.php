<?php

namespace Capmega\Base\Models\Ubication;

use Capmega\Base\Models\ResourceModel;

class Country extends ResourceModel
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules($params)
    {
        return [
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

    /**
     * Devuelve el usuario que creo el elemento
     * @return [type] [description]
     */
    public function createdBy()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    /**
     * Devuelve el ultimo usuario que modifico este elemento
     * @return [type] [description]
     */
    public function updatedBy()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }
}
