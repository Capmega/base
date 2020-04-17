<?php
namespace Capmega\Base\Widgets\Grid;

use Capmega\Base\Widgets\Grid\{ActionColumn, SearchForm};
use Capmega\Base\Helpers\Html;
use Request;

/**
 *
 */
class GridView
{
    private $models;
    private $model;
    private $options = [];
    private $optionsHtml = ['class' => 'table'];
    private $key;
    private $route;
    private $attributes;
    private $url;
    private $order;
    private $is_desc;
    private $action_column;
    private $search = true;
    private $redirect_columns = false;

    public static function generate(array $params)
    {
        $object                   = new Self();
        $object->search           = $params['search']??true;
        $object->models           = $params['models'];
        $object->model            = $params['model'];
        $object->route            = $params['route'];
        $object->key              = $params['key']??'seoname';
        $object->attributes       = $params['attributes'];
        $object->action_column    = $params['action_column']??'default';
        $object->redirect_columns = $params['redirect_columns']??false;

        return $object;
    }

    public function render()
    {
        if (!$this->models->count()) {
            return $this->begin().
                   '<br>
                    <div class="alert alert-danger" role="alert">
                    '.__('base::messages.empty').'
                    </div>'.
                    $this->end();
        }
        return $this->begin().
        $this->getHead().
        $this->getBody().
        $this->end();
    }

    private function getFiter()
    {
        if (!$this->search) {
            return '';
        }

        return new SearchForm($this->model);
    }

    public function __toString()
    {
        return $this->render();
    }

    private function getBody()
    {
        $code  = '<tbody>';

        foreach ($this->models as $index => $model) {
            $code .= '<tr>
                            <td>' . ($index+1) . '</td>';

            foreach ($this->attributes as $index => $attribute) {
                $code .= '<td>';
                if ($this->redirect_columns) {
                    $key = $this->key;
                    $code .= '<a href="'.route($this->route.'.show', $model->$key).'">';
                }
                if (is_array($attribute)) {
                    $code .= $attribute['value']($model);
                }else{
                    $code .= $this->findAttribute($model, $attribute);
                }
                if ($this->redirect_columns) {
                    $code .= '</a>';
                }
                $code .= '</td>';
            }

            $code .= '     <td>
                                '.$this->actionColumn($model).'
                            </td>
                        </tr>';
        }

        $code .= '  </tbody>';

        return $code;
    }

    private function getHead()
    {
        $code = '<thead>
                    <tr>
                        <th>#</th>';
        foreach ($this->attributes as $index => $attribute) {
            if (is_array($attribute)) {
                if (isset($attribute['label'])) {
                    $code .= ' <th>' . $attribute['label'] . '</th>';
                }else{
                    $code .= ' <th>' . $this->isSort($attribute['attribute']) . '</th>';
                }
            }else{
                $code .= ' <th>' . $this->isSort($attribute) . '</th>';
            }
        }

        $code .= '      <th></th>
                    </tr>
                 </thead>';
        return $code;
    }

    private function findAttribute($model, $attribute)
    {
        if (strpos($attribute, '.') !== false) {
            $relation = $this->getRelation($model, $attribute);

            if ($relation[0]) {
                $relation_attribute = $relation[1];
                return $relation[0]->$relation_attribute;
            }

            return  __('base::messages.not_assigned');
        }

        return $model->$attribute;
    }

    private function getRelation($model, $attribute)
    {
        $new_atribute = explode('.', $attribute);
        $relation_attribute = $new_atribute[1];
        $relation = $new_atribute[0];
        $relation = $model->$relation;
        return [
            $relation,
            $relation_attribute
        ];
    }

    private function begin()
    {
        $this->getOrder();
        return Html::startTag('div', $this->options).
               $this->getFiter().
               Html::startTag('div', ['class' => 'table-responsive']).
               Html::startTag('table', $this->optionsHtml);
    }

    private function end()
    {
        return Html::endTag('table').$this->models->links().Html::endTag('div').Html::endTag('div');
    }

    private function actionColumn($model)
    {
        if ($this->action_column == 'default') {
            return ActionColumn::generate($model, $this->route, $this->key);
        }

        if (!$this->action_column) {
            return '';
        }
        $action = $this->action_column['class'];
        return $action::generate($model, $this->action_column['route'], $this->action_column['id'], $this->action_column['template']);
    }

    private function getOrder()
    {
        if (!$this->search) {
            return '';
        }

        $this->order   = $_GET['order']??false;
        $this->is_desc = strpos( $this->order, '-' ) !== false;

        $has_query = strpos( Request::fullUrl(), '?' ) !== false;
        $new_url   = Request::fullUrl();

        if($has_query){
            if(strpos( $new_url, 'order=' ) !== false){
                $new_url = explode('?', $new_url);
                $new_url = $new_url[0] . '?';
                foreach (Request::query() as $key => $value) {
                    if ($key != 'order') {
                        $new_url .= $key. '=' .$value . '&';
                    }
                };
                $new_url .= 'order=';
            }else{
                $new_url = $new_url . '&order=';
            }
        }else{
            $new_url = $new_url . '?order=';
        }

        $this->url = $new_url;
    }

    private function isSort($attribute)
    {
        if (!$this->search) {
            return $this->getLabel($this->model, $attribute);
        }

        if(strpos($attribute, '.' ) !== false){
            $attribute = explode('.',$attribute);
            $attribute = $attribute['1'];
        }

        if(strpos( $this->order, $attribute ) !== false){
            if($this->is_desc){
                return '<a href="'.$this->url.''.$attribute.'"> '.$this->getLabel($this->model, $attribute).'  <i class="la la-arrow-down" aria-hidden="true"></i></a>';
            }else{
                return '<a href="'.$this->url.'-'.$attribute.'"> '.$this->getLabel($this->model, $attribute).'  <i class="la la-arrow-up" aria-hidden="true"></i></a>';
            }
        }else{
            return '<a href="'.$this->url.'-'.$attribute.'"> '.$this->getLabel($this->model, $attribute).' </a>';
        }
    }

    private function getLabel($model, $attribute)
    {
        return $this->model->getLabel($attribute);
    }

}
