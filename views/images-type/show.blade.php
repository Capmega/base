@php
use Capmega\Base\Widgets\Grid\Details;
use Capmega\Base\Widgets\Information\BreadCrumb;
@endphp
@extends('base::layouts.main')

@section('title_tab', __('base::attributes.images-type.show'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'images-type.index' => __('base::attributes.images-type.items'),
        'Active'    => __('base::attributes.images-type.show'),
        ]) ?>
@endsection

@section('content')

    @card({{__('base::attributes.images-type.show')}})
        <?= Details::generate($model, [
            'id',
            'created_at',
            'updated_at',
            'status',
            'updated_by',
            'deleted_by',
            'deleted_reason',
            'deleted_at',
            'name',
            'seoname',
            'sizes',
            
        ])?>
    @endcard
@endsection
