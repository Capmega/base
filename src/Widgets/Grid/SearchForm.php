<?php
namespace Capmega\Base\Widgets\Grid;

use Capmega\Base\Helpers\Html;
use Illuminate\Support\Facades\URL;
use Request;

/**
 *
 */
class SearchForm
{
    private $models;
    private $model;
    private $options = [];
    private $attributes;
    private $ignore = ['order', 'sort'];
    private $order;

    function __construct($model)
    {
        $this->model = $model;
    }

    public function render()
    {
        return $this->begin().
        $this->getButton().
        $this->getFilters().
        $this->end();
    }

    public function __toString()
    {
        return $this->render();
    }

    private function getButton()
    {
        $this->params = Request::all();
        $this->order = $this->params['order']??false;
        foreach ($this->ignore as $key => $value) {
            unset($this->params[$value]);
        }

        return '<span
                    data-show-target="#advanced-search"
                    data-show-action="show"
                    style="'.($this->isOpen()?'display: none':'').'"
                    class="btn btn-info btn-rounded show-element ">'.__('base::messages.advanced_search').' <i class="la la-arrow-down" aria-hidden="true"></i>
                </span>

                <span
                    data-show-target="#advanced-search"
                    data-show-action="hide"
                    style="'.($this->isOpen()?'':'display: none').'"
                    class="btn btn-info btn-rounded show-element"
                    >'.__('base::messages.advanced_search').' <i class="la la-arrow-up" aria-hidden="true"></i>
                </span>
                <br>
                <br>';
    }

    private function isOpen()
    {
        if (config('base.search.default')) {
            return true;
        }
        return $this->params;
    }

    private function getLastButton()
    {
        return '<div class="row">
                    <div class="col-sm-12">
                        <br>
                        <div class="btn-group pull-right">
                            <button class="btn btn-sm btn-info" type="submit">
                                <i class="la la-search"></i>
                                '.__('base::messages.search').'
                            </button>
                            <a class="btn btn-sm btn-warning" href="'.URL::current().'">
                                <i class="la la-eraser"></i>
                                '.__('base::messages.clear').'
                            </a>
                        </div>
                    </div>
                </div>';
    }

    private function getFilters()
    {
        $params = $this->params;
        $code = '<div id="advanced-search" class="form-group" style="'.($this->isOpen()?'':'display: none').'">
            <form action="'.URL::current().'" method="get">
                <input name="order" value="'.($this->order??'').'" type="hidden">
                <div class="row">';

                foreach ($this->model->filters??[] as $key => $attribute) {
                    $code .= '<div class="col-md-2">';

                              if (is_array($attribute)) {
                                  $code .= '<label>'.$this->model->getLabel($key).'</label>';
                                  switch ($attribute['type']??'text') {
                                      case 'dropdown':
                                          $code .= '<select name="'.$key.'" class="form-control" >';
                                          $code .= '<option value="">'.__('base::messages.select_element').'</option>';
                                          foreach ($attribute['options'] as $keys => $value) {
                                              $code .= '<option value="'.$keys.'" '.(($params[$key]??'')==$keys?'selected':'').'>'.$value.'</option>';
                                          }
                                          $code .= '</select>';
                                          break;
                                      case 'date':
                                      case 'date_less':
                                      case 'date_higher':
                                          $code .= '<input class="form-control" type="date" name="'.$key.'" value="'.($params[$key]??'').'">';
                                          break;

                                      default:
                                          $code .= '<input class="form-control" type="text" name="'.$key.'" value="'.($params[$key]??'').'">';
                                          break;
                                  }
                              }else{
                                  $code .= '<label>'.$this->model->getLabel($attribute).'</label>';
                                  $code .= '<input class="form-control" type="text" name="'.$attribute.'" value="'.($params[$attribute]??'').'">';
                              }

                    $code .= '</div>';
                }

        $code .= '<div class="col-md-2">
                        <label>'.__('base::messages.pagination').'</label>
                        <select class="form-control" name="pagination" value="'.($params['pagination']??'').'">
                            <option value="">'.__('base::messages.select_element').'</option>';
                            foreach (config('base.pagination') as $key => $value) {
                                $code .= '<option value="'.$value.'" '.($value==($params["pagination"]??"false")?"selected":"").'>'.__('base::messages.per_pagination', ['items' => $value]).'</option>';
                            }
        $code .=       '</select>
                    </div>
                </div>

            '.$this->getLastButton().'</form>'.'
        </div>';

        return $code;
    }

    private function begin()
    {
        return Html::startTag('div', $this->options);
    }

    private function end()
    {
        return Html::endTag('div');
    }

}
