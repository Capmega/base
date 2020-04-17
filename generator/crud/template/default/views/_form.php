@php
use Capmega\Base\Widgets\Form\ActiveField;
@endphp

<?php
    foreach ($this->new_model->getTableColumns() as $key => $value){
        if ($value != 'id'
        AND $value != 'seoname'
        AND $value != 'created_at'
        AND $value != 'updated_at'
        AND $value != 'status'
        AND $value != 'created_by'
        AND $value != 'updated_by'
        AND $value != 'deleted_by'
        AND $value != 'deleted_reason'
        AND $value != 'deleted_at'){
            echo '<?= ActiveField::Input($model, \''.$value.'\')?>
';
        }
    }
?>

<div class="form-group">
    <button type="submit" class="btn btn-primary">@lang('base::messages.save')</button>
</div>
