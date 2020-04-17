<?php
namespace Capmega\Base\Widgets\Grid;

/**
 *
 */
class Details
{
    public static function generate($model, $attributes)
    {
        $table  = '<div class="table-responsive"><table class="table table-striped">';
        foreach ($attributes as $index => $attribute) {
            $table .= '<tr>';
            if (is_array($attribute)) {
                if (isset($attribute['label'])) {
                    $table .= ' <th>' . $attribute['label'] . '</th>';
                }else{
                    $table .= ' <th>' . $model->getLabel($attribute['attribute']) . '</th>';
                }
                if (is_callable($attribute['value'])) {
                    $table .= ' <td>' . $attribute['value']($model) . '</td>';
                }  else {
                    $table .= ' <td>' . $attribute['value'] . '</td>';
                }

            }else{
                $table .= ' <th>' . $model->getLabel($attribute) . '</th>';
                $table .= ' <td>' . $model->$attribute . '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</table></div>';
        return $table;
    }
}
