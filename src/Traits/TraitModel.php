<?php
namespace Capmega\Base\Traits;

use Capmega\Base\Helpers\Helpers;

/**
 *
 */
trait TraitModel
{
    /**
     * Obtiene los atributos por los cuales que se puede buscar
     */
    public function getFiltersAttribute()
    {
        return [
            'status' => [
                'type' => 'dropdown',
                'options' => $this->getStatus()
            ]
        ];
    }

    /**
     * Get default client attributes values.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'created_at'     => __('base::attributes.created_at'),
            'updated_at'     => __('base::attributes.updated_at'),
            'deleted_at'     => __('base::attributes.deleted_at'),
            'created_by'     => __('base::attributes.created_by'),
            'updated_by'     => __('base::attributes.updated_by'),
            'deleted_by'     => __('base::attributes.deleted_by'),
            'deleted_reason' => __('base::attributes.deleted_reason'),
            'status'         => __('base::attributes.status'),
            'name'           => __('base::attributes.name'),
            'seoname'        => __('base::attributes.seoname'),
        ];
    }

    /**
     * Get beauty name for one attribute.
     *
     * @return String beauty name
     */
    public function getLabel(string $attribute){
        try {
            return $this->attributes()[$attribute];
        } catch (\Exception $e) {
            return ucfirst(str_replace('_', ' ', $attribute));
        }
    }

    /**
     * [getRule description]
     * @param  string  $attribute [description]
     * @param  boolean $rule      [description]
     * @param  string  $rules     [description]
     * @return [type]             [description]
     */
    public function getRule(string $attribute, $rules = 'rules', $rule = false)
    {
        if (isset($this->$rules([])[$attribute])) {
            $rule_values = $this->$rules([])[$attribute];
            if (is_array($rule_values)) {
                $rule_values = implode('|', $rule_values);
            }

            if ($rule) {
                if (strpos($rule_values, $rule) !== false) {
                    return true;
                }
                return false;
            }

            return explode('|', $rule_values);
        }
    }

    /**
     * Get all default status
     * @return array all default status
     */
    public function getStatus()
    {
        return [
            Self::STATUS_DELETE   => __('base::attributes.status_colum.delete'),
            Self::STATUS_CREATE   => __('base::attributes.status_colum.create'),
            Self::STATUS_INACTIVE => __('base::attributes.status_colum.inactive'),
            Self::STATUS_ACTIVE   => __('base::attributes.status_colum.active'),
        ];
    }

    /**
     * Get value of status
     * @param  number $value status number to conver a beauty string
     * @return string        beauty value of status
     */
    public function getStatusAttribute($value)
    {
        if (isset($this->getStatus()[$value])) {
            return $this->getStatus()[$value];
        }

        return ucfirst($value);
    }

    /**
     * Check if current model has one attribute
     * @param  string  $attr searched attribute
     * @return boolean       if attribute exists
     */
    public function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes());
    }

    /**
     * Check if current model has one filter
     * @param  string  $attr searched filter
     * @return boolean       if filter exists
     */
    public function hasFilter($attr)
    {
        if (array_key_exists($attr, $this->filters)) {
            return true;
        }

        foreach ($this->filters as $key => $value) {
            if ($value == $attr) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get one filter
     * @param  string  $attr searched filter
     * @return mixed       current filter or false if not exist
     */
    public function getFilter($attr)
    {
        if (array_key_exists($attr, $this->filters)) {
            return $this->filters[$attr];
        }

        foreach ($this->filters as $key => $value) {
            if ($value == $attr) {
                return $attr;
            }
        }
        return false;
    }

    /**
     * Get list with all columns
     * @return [type] [description]
     */
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    /**
     * check if current model has specified column
     * @return boolean
     */
    public function hasColumn($column) {
        if (in_array($column, $this->getTableColumns())) {
            return true;
        }
        return false;
     }

    /**
     * get id and name in array
     * @return array
     */
    public static function getSelect($key = 'id', $name = 'name', $status = Self::STATUS_ACTIVE) {
        return Self::select($key, $name)
        ->where('status', $status)
        ->get()
        ->mapWithKeys(function ($model) use ($key, $name) {
            return [$model[$key] => $model[$name]];
        });
    }

    public static function getParseRules($model, $rules){
        $custom = [];
        foreach ($rules as $attribute => $rule) {
            $custom[str_replace(' ', '_', $model->getLabel($attribute))] = $rule;
        }
        return $custom;
    }

    public static function getParseRequest($model, $request){
        $custom = [];
        foreach ($request as $attribute => $value) {
            $clean_attribute = str_replace($model->getTable().'_', '', $attribute);
            if ($model->getTable().'_'.$clean_attribute == $attribute) {
                if (strpos($clean_attribute, '_confirmation') !== false) {
                    $confirm_attr = explode('_confirmation', $clean_attribute);
                    $custom[str_replace(' ', '_', $model->getLabel($confirm_attr[0]).'_confirmation')] = $value;
                }else{
                    $custom[str_replace(' ', '_', $model->getLabel($clean_attribute))] = $value;
                }
            }
        }
        return $custom;
    }

    /*
     * Static method to create or update a record
     * $valWhere : It is an associative array to perform the search of the record to validate
     * $newValues : It is an associative array to make the new record or update it, as a complement to it
     */
    public static function createOrUpdate($valWhere,$newValues){
      $modelClass = get_called_class();
      $model = $modelClass::where($valWhere)->first();
      $attributes = $valWhere + $newValues;

      if(!$model){
        $model = new $modelClass();
      }

      foreach ($attributes as $key => $value) {
        $model[$key] = $value;
      }
      return $model;
    }

    public function getRuleLabel($attribute){
        return str_replace(' ', '_', $this->getLabel($attribute));
    }

    public function messages(){
        return [];
    }

    public function getMessages(){
        $messages = $this->messages();
        $custom_messages = [];
        foreach ($messages as $attribute => $message) {
            if (strpos($attribute, '.') !== false) {
                $attribute = \explode('.', $attribute);
                $custom_messages[$this->getRuleLabel($attribute[0]).'.'.$attribute[1]] = $message;
            }else{
                $custom_messages[$attribute] = $message;
            }
        }
        return $custom_messages;
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

    /**
     * Devuelve el ultimo usuario que modifico este elemento
     * @return [type] [description]
     */
    public function deletedBy()
    {
        return $this->hasOne('App\User', 'id', 'updated_by');
    }

    /**
     * [generateSeoname description]
     * @return [type] [description]
     */
    public function generateSeoname($attribute = 'name', $seoattribute = 'seoname')
    {
        if (empty($this->id) or $this->isDirty($attribute)) {
            $this->$seoattribute = Helpers::toSeo($this->$attribute);
            $count = $this::where($seoattribute, $this->$seoattribute)->orWhere($seoattribute, 'like', $this->$seoattribute . '-%')->count();

            if ($count) {
                $count++;
                $this->$seoattribute = $this->$seoattribute . '-' . $count;
            }
        }
    }
}
