<?php
namespace Capmega\Base\Widgets\Form;

use Capmega\Base\Helpers\Html;
/**
 * Generate a Html input
 */
class ActiveField
{
    private $model;
    private $attribute;
    private $options = ['class' => 'form-group'];
    private $icon = '';
    private $classContainer = 'controls';
    private $optionsHtml  = ['class' => 'form-control'];
    private $labelOptions = ['class' => ''];
    private $errorOptions = ['class' => 'text-danger'];
    private $label = true;
    private $input = '';
    private $icon_prepend = '';
    private $icon_append = '';
    public static $rules = 'rules';
    public static $errors = false;
    public static $invidivual_error = false;

    public static function input($model, $attribute, $options = [])
    {
        $object           = new Self;
        $object->model    = $model;
        $object->attribute = $attribute;
        $object->options  = array_merge($object->options, $options);

        return $object;
    }

    public function textInput($optionsHtml = [])
    {
        $this->optionsHtml = array_merge($this->optionsHtml, $optionsHtml);
        $this->getHtmlOptions();
        $this->input = '<input
        '.$this->jqueryRules().'
        type="text"
        name="'.$this->model->getTable().'_'.$this->attribute.'"
        '.Html::setAttributes($this->optionsHtml).'
        value="'.$this->getValue().'" />';
        return $this;
    }

    private function jqueryRules()
    {
        return ($this->getRule($this->attribute, 'required')?' required data-validation-required-message="'.__('validation.required', ['attribute' => $this->model->getLabel($this->attribute)]).'"':'');
    }

    public function hiddenInput($optionsHtml = [])
    {
        $this->optionsHtml = array_merge($this->optionsHtml, $optionsHtml);
        $this->getHtmlOptions();
        $this->input = '<input
        '.$this->jqueryRules().'
        type="hidden"
        name="'.$this->model->getTable().'_'.$this->attribute.'"
        '.Html::setAttributes($this->optionsHtml).'
        value="'.$this->getValue().'" />';
        return $this;
    }

    public function passwordInput($optionsHtml = [])
    {
        $this->optionsHtml = array_merge($this->optionsHtml, $optionsHtml);
        $this->getHtmlOptions();
        $this->input = '<input
        '.$this->jqueryRules().'
        type="password"
        name="'.$this->model->getTable().'_'.$this->attribute.'"
        '.Html::setAttributes($this->optionsHtml).'
        value="" />';
        return $this;
    }

    public function dateInput($optionsHtml = [])
    {
        $this->optionsHtml = array_merge($this->optionsHtml, $optionsHtml);
        $this->getHtmlOptions();
        $this->input = '<input
        '.$this->jqueryRules().'
        type="date"
        name="'.$this->model->getTable().'_'.$this->attribute.'"
        '.Html::setAttributes($this->optionsHtml).'
        value="'.$this->getValue().'" />';
        return $this;
    }


    /**
     * Method to create a input number type
     * @param  array  $optionsHtml associative array for html attributes
     * @return ActiveField->numberInput returns html code of an input number
     */
     public function numberInput($optionsHtml = [])
     {
        $this->optionsHtml = array_merge($this->optionsHtml, $optionsHtml);
        $this->getHtmlOptions();
        $this->input = '<input
        '.$this->jqueryRules().'
        type="number"
        name="'.$this->model->getTable().'_'.$this->attribute.'"
        '.Html::setAttributes($this->optionsHtml).'
        value="'.$this->getValue().'" />';
        return $this;
     }


    public function checkBox($optionsHtml = [])
    {
        $optionsHtml['class'] = $optionsHtml['class']??'custom-control-input';
        $this->optionsHtml = array_merge($this->optionsHtml, $optionsHtml);
        $this->input = '<div class="custom-control custom-checkbox" style="margin-top: 30px">
                            <input type="checkbox"
                            name="'.$this->model->getTable().'_'.$this->attribute.'"
                            id="'.$this->model->getTable().'_'.$this->attribute.'"
                            '.Html::setAttributes($this->optionsHtml).'>
                            <label class="custom-control-label" for="'.$this->model->getTable().'_'.$this->attribute.'">'.$this->generateLabel().'</label>
                        </div>';
        $this->label = false;
        return $this;
    }



    /**
     * Method to create a input radio type
     * @param  array $values       associative array, [input value => value to display on screen]
     * @param  [type] $checked     value of the input to check
     * @param  [type] $orientation orientación de los radio ,v : vertical, h: horizontal
     * @param  array  $optionsHtml associative array for html attributes
     * @return ActiveField->radioGroup returns html code of an input radio
     */
    public function radioGroup($values,$checked,$orientation,$optionsHtml = [])
    {
      $this->input .= '<br>';
      $this->optionsHtml = $optionsHtml;
      $horizontal = $orientation != 'v' ? 'radio-inline' : 'radio';
      foreach ($values as $key => $value) {
        $check_default = ($checked == $key) ? 'checked' : '';
        $chek_old = $this->getValue() == $key ? 'checked' : '';
        $check = (empty($chek_old)) ? $check_default : $chek_old;
        $this->input .= '
        <label class="'.$horizontal.'" '.Html::setAttributes($this->optionsHtml).'>
        <input type="radio"
        name="'.$this->model->getTable().'_'.$this->attribute.'"
        value="'.$key.'" '.$check.'>'.$value.'</label>';
      }
      return $this;
    }

    public function select($items, $optionsHtml = [])
    {
        $this->optionsHtml = array_merge($this->optionsHtml, $optionsHtml);
        $this->getHtmlOptions();

        $options = '';
        foreach ($items as $key => $item) {
            $options .= '<option value="'.$key.'" '.($key==$this->getValue()?'selected':'').'>'.$item.'</option>';
        }

        $this->input =
        '<select name="'.$this->model->getTable().'_'.$this->attribute.'"'.
        Html::setAttributes($this->optionsHtml).'>'.
            '<option value="">'.__('base::messages.select_element').'</option>'.
            $options.
        '</select>';
        return $this;
    }

    public function textArea($optionsHtml = [])
    {
        $this->optionsHtml = array_merge($this->optionsHtml, $optionsHtml);
        $this->getHtmlOptions();

        $this->input =
        '<textarea
        '.$this->jqueryRules().'
        id="'.$this->attribute.'"
        name="'.$this->model->getTable().'_'.$this->attribute.'"
        rows="8"
        cols="80"
        '.Html::setAttributes($this->optionsHtml).'>'.
        $this->getValue().'</textarea>';

        return $this;
    }

    public function fileInput($optionsHtml = [])
    {
        $this->optionsHtml = array_merge($this->optionsHtml, $optionsHtml);
        $this->getHtmlOptions();

        $this->input = '<input
        '.$this->jqueryRules().'
        type="file"
        name="'.$this->model->getTable().'_'.$this->attribute.(isset($optionsHtml['multiple']) ? '[]':'').'"
        '.Html::setAttributes($this->optionsHtml).' >';
        return $this;
    }

    private function getHtmlOptions(){
        if ($this->getErrors()) {
            $this->optionsHtml['class'] = $this->optionsHtml['class'].' is-invalid';
        }
    }

    private function begin()
    {
        if ($this->getErrors()) {
            $this->options['class'] = $this->options['class'].' errors';
        }
        // $this->options = array_merge($this->options, ['id' => $this->model->getTable().'_'.$this->attribute.'_form']);
        return Html::startTag('div', $this->options);
    }

    private function end()
    {
        return Html::endTag('div');
    }


    public function inputGroupPrepend($icon)
    {
        $this->icon_prepend = '<div class="input-group-prepend">
                                   <span class="input-group-text">' . $icon . '</span>
                               </div>';
        return $this;
    }

    public function inputGroupAppend($icon)
    {

        $this->icon_append = '<div class="input-group-append">
                                  <span class="input-group-text">' . $icon . '</span>
                              </div>';
        return $this;
    }

    public function render()
    {
        if (!$this->input) {
            $this->textInput();
        }
        return $this->begin().
        $this->generateLabel().
        '<fieldset class="'.$this->classContainer.'">'.
        '<div class="input-group">'.
        $this->icon_prepend.
        $this->input.
        (Self::$invidivual_error?Html::getAttributeErrors($this->getErrors(), $this->errorOptions):'').
        $this->icon.
        $this->icon_append.
        '</div>'.
        '</fieldset>'.
        $this->end();
    }

    public function getErrors(){
        if (Self::$errors) {
            return Self::$errors->get($this->model->getRuleLabel($this->attribute));
        }
        return false;
    }

    public function label(bool $label, array $options = [])
    {
        $this->options['class'] = '';
        $this->labelOptions = array_merge($this->labelOptions, $options);
        $this->label = $label;
        return $this;
    }

    public function generateLabel()
    {
        if ($this->label) {
            return Html::startTag('h5', $this->labelOptions).
            $this->model->getLabel($this->attribute).
            ($this->getRule($this->attribute, 'required')?' <span class="required">*</span>':'').
            Html::endTag('h5');
        }
        return '';
    }

    private function getRules()
    {
        return true;
    }

    private function getRule($attribute, $rule = false)
    {
        return $this->model->getRule($this->attribute, Self::$rules, $rule);
    }

    public function getValue()
    {
        $attribute = $this->attribute;

        if (old($this->model->getTable().'_'.$attribute)) {
            return old($this->model->getTable().'_'.$attribute);
        }

        if ($this->model->$attribute) {
            return $this->model->$attribute;
        }

        return '';
    }

    public function keyValues($keys, $options = [])
    {
        $html = '<div class="row form-group">';
        foreach ($keys as $key => $value) {
            $value_key = $this->model->getKeyValue($value['seoname']);
            $html .= '<div class="'.($options['col_size']??'col-md-4').' form-group">
                          <label for="">'.$value['name'].'</label>
                          <input type="text" name="'.$this->model->getTable().'_bkeys_'.$value['name'].'" value="'.(old($value['name'])?old($value['name']):($value_key?$value_key->value:'')).'" class="form-control">
                      </div>';
          }
        $html .= '</div>';
        return $html;
    }

    public function icon($icon, $type = 'success', $font = 'font-medium-4')
    {
        $this->classContainer .= ' has-icon-left';
        $this->icon = '<div class="form-control-position"><i class="'.$icon.' '.$type.' '.$font.'"></i></div>';
        return $this;
    }

    public function __toString()
    {
        return $this->render();
    }

}
