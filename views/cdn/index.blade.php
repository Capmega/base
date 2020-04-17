@php
use Capmega\Base\Widgets\Grid\GridView;
use Capmega\Base\Widgets\Information\{BreadCrumb};
use Capmega\Base\Widgets\Messages\Alert;
@endphp
@extends('base::layouts.main')

@section('title_tab', __('base::attributes.cdn.items'))


@section('breadcrumb')
    <?= BreadCrumb::generate([
        'Active'    => __('base::attributes.cdn.items'),
        ]) ?>
@endsection

@section('content')

    @card({{__('base::attributes.cdn.items')}})
    <div class="form-group">
        <a href="{{route('cdn.create')}}" class="btn btn-primary"> @lang('base::attributes.cdn.create') </a>
    </div>
    <?= Alert::generate() ?>
    <?= GridView::generate([
        'model' => $model,
        'models' => $models,
        'route' => 'cdn',
        'key' => 'id',
        'attributes' => [
            'created_at',
            'status',
            'type',
            'domain',
            'api_key',
        ]
    ])?>
    @endcard
@endsection
