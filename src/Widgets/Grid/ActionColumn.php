<?php
namespace Capmega\Base\Widgets\Grid;

/**
 *
 */
class ActionColumn
{


    public static function generate($model, $route, $id = 'seoname', $template = ['delete', 'edit', 'show'])
    {
        $value = '<div class="action_column">';
        $value .= '<form action="'.route($route.'.destroy', $model->$id).'" method="POST">
                     '.method_field('DELETE').'
                     '.csrf_field().'';

        if (in_array('delete', $template)) {
            $value .= '<button
                      type="submit"
                      data-question-title="'.__('base::messages.delete_item').'"
                      data-question-text=""
                      data-question-accept="false"
                      data-question-continue="'.__('base::messages.continue').'"
                      data-question-cancel="'.__('base::messages.cancel').'"
                      class="btn btn-danger question"
                      ><i class="la la-trash-o" aria-hidden="true"></i></button> ';
        }

        if (in_array('edit', $template)) {
              $value .= '<a href="'.route($route.'.edit', $model->$id).'" class="btn btn-primary"><i class="la la-pencil-square-o" aria-hidden="true"></i></a> ';
        }

        if (in_array('show', $template)) {
            $value .= '<a href="'.route($route.'.show', $model->$id).'" class="btn btn-success"><i class="la la-eye" aria-hidden="true"></i></a> ';
        }

        foreach ($template as $item) {
            if (is_array($item)) {
                $route = [];
                foreach ($item[':route'] as $key => $route_value) {
                    if ($key != 'name') {
                        $route[$key] = $route_value($model);
                    }
                }
                $route = route($item[':route']['name'], $route);
                $value .= str_replace(':route', $route, $item['template']);
            }
        }

        $value .= '</form>';


        $value .= '</div>';
        return $value;
    }
}
