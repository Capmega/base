@php
use Capmega\Base\Widgets\Form\ActiveField;
@endphp

<?= ActiveField::Input($model, 'type')?>
<?= ActiveField::Input($model, 'domain')?>
<?= ActiveField::Input($model, 'api_key')?>

<div class="form-group">
    <button type="submit" class="btn btn-primary">@lang('base::messages.save')</button>
</div>
