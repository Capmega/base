@php
use Capmega\Base\Widgets\Form\ActiveField;
use Capmega\Base\Helpers\SizeComponent;
@endphp

<?= ActiveField::Input($model, 'name')?>

<?= SizeComponent::generate(json_encode($model->sizes), 'images-type', $model->id)->render() ?>

<div class="form-group">
    <button type="submit" class="btn btn-primary">@lang('base::messages.save')</button>
</div>
