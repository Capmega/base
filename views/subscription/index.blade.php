@php
use Capmega\Base\Widgets\Grid\GridView;
use Capmega\Base\Widgets\Information\{BreadCrumb};
use Capmega\Base\Widgets\Messages\Alert;
@endphp
@extends('base::layouts.main')

@section('title_tab', __('base::attributes.subscription.items'))


@section('breadcrumb')
    <?= BreadCrumb::generate([
        'Active'    => __('base::attributes.subscription.items'),
        ]) ?>
@endsection

@section('content')

    @card({{__('base::attributes.subscription.items')}})
    <div class="form-group">
        <a href="{{route('subscription.csv')}}" class="btn btn-primary"> @lang('base::attributes.subscription.download') </a>
    </div>
    <?= Alert::generate() ?>
    <?= GridView::generate([
        'model' => $model,
        'models' => $models,
        'route' => 'subscription',
        'key' => 'id',
        'attributes' => [
            'email'
        ],
        'action_column' => [
            'class' => new \Capmega\Base\Widgets\Grid\ActionColumn,
            'template' => ['delete'],
            'route' => 'subscription',
            'id' => 'id'
        ],
    ])?>
    @endcard
@endsection
