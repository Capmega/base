@php
use Capmega\Base\Widgets\Form\ActiveField;
use Capmega\Base\Helpers\SizeComponent;
@endphp

<div class="row">
    <div class="col-md-6">
        <?= ActiveField::Input($model, 'route')?>
    </div>
    <div class="col-md-6">
        <?= ActiveField::Input($model, 'name')?>
    </div>
</div>
<?= ActiveField::Input($model, 'alt')?>
<?= ActiveField::Input($model, 'image')->fileInput()?>

<?= SizeComponent::generate(json_encode($model->sizes), 'images', $model->id)->render() ?>

<div class="form-group">
    <button type="submit" class="btn btn-primary">@lang('base::messages.save')</button>
</div>
