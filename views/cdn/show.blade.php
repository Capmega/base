@php
use Capmega\Base\Widgets\Grid\Details;
use Capmega\Base\Widgets\Information\BreadCrumb;
@endphp
@extends('base::layouts.main')

@section('title_tab', __('base::attributes.cdn.show'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'cdn.index' => __('base::attributes.cdn.items'),
        'Active'    => __('base::attributes.cdn.show'),
        ]) ?>
@endsection

@section('content')

    @card({{__('base::attributes.cdn.show')}})
        <?= Details::generate($model, [
            'id',
            'created_at',
            'updated_at',
            'status',
            'updated_by',
            'deleted_by',
            'deleted_reason',
            'deleted_at',
            'type',
            'domain',
            'api_key',
            
        ])?>
    @endcard
@endsection
