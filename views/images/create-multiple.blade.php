@php
use Capmega\Base\Widgets\Information\{BreadCrumb};
use Capmega\Base\Widgets\Messages\Error;
use Capmega\Base\Widgets\Form\ActiveField;
use Capmega\Base\Models\ImageType;
@endphp

@extends('base::layouts.main')

@section('title_tab', __('base::attributes.images.create'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'images.index' => __('base::attributes.images.items'),
        'Active'    => __('base::attributes.images.create'),
        ]) ?>
@endsection

@section('content')
    @card({{__('base::attributes.images.create')}})

    <?= Error::generate($errors) ?>
    <form action="{{route('images.create-multiple')}}" method="post" enctype="multipart/form-data">
        @csrf

        <?= ActiveField::Input($model, 'image_types_id')->select(ImageType::getSelect())?>
        <div class="row">
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'route')?>
            </div>
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'name')?>
            </div>
        </div>
        <?= ActiveField::Input($model, 'alt')?>
        <?= ActiveField::Input($model, 'image')->fileInput(['multiple'=>true])?>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">@lang('base::messages.save')</button>
        </div>

    </form>
    @endcard
@endsection
