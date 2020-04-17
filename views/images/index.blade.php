@php
use Capmega\Base\Widgets\Grid\GridView;
use Capmega\Base\Widgets\Information\{BreadCrumb};
use Capmega\Base\Widgets\Messages\Alert;
@endphp
@extends('base::layouts.main')

@section('title_tab', __('base::attributes.images.items'))


@section('breadcrumb')
    <?= BreadCrumb::generate([
        'Active'    => __('base::attributes.images.items'),
        ]) ?>
@endsection

@section('content')

    @card({{__('base::attributes.images.items')}})
    <div class="form-group">
        <a href="{{route('images.create')}}" class="btn btn-primary"> @lang('base::attributes.images.create') </a>
        <a href="{{route('images.create-multiple')}}" class="btn btn-primary"> @lang('base::attributes.images-type.create_multiple') </a>
    </div>
    <?= Alert::generate() ?>
    <?= GridView::generate([
        'model' => $model,
        'models' => $models,
        'route' => 'images',
        'key' => 'id',
        'attributes' => [
            'route',
            'name',
            'seoname',
            'extension',
            'status',
        ]
    ])?>
    @endcard
@endsection
