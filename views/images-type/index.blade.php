@php
use Capmega\Base\Widgets\Grid\GridView;
use Capmega\Base\Widgets\Information\{BreadCrumb};
use Capmega\Base\Widgets\Messages\Alert;
@endphp
@extends('base::layouts.main')

@section('title_tab', __('base::attributes.images-type.items'))


@section('breadcrumb')
    <?= BreadCrumb::generate([
        'Active'    => __('base::attributes.images-type.items'),
        ]) ?>
@endsection

@section('content')

    @card({{__('base::attributes.images-type.items')}})
    <div class="form-group">
        <a href="{{route('images-type.create')}}" class="btn btn-primary"> @lang('base::attributes.images-type.create') </a>
    </div>
    <?= Alert::generate() ?>
    <?= GridView::generate([
        'model' => $model,
        'models' => $models,
        'route' => 'images-type',
        'key' => 'seoname',
        'attributes' => [
            'name',
        ]
    ])?>
    @endcard
@endsection
