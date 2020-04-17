@php
use Capmega\Base\Widgets\Grid\Details;
use Capmega\Base\Widgets\Information\BreadCrumb;
@endphp
@extends('base::layouts.main')

@section('title_tab', __('base::attributes.subscription.show'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'subscription.index' => __('base::attributes.subscription.items'),
        'Active'    => __('base::attributes.subscription.show'),
        ]) ?>
@endsection

@section('content')

    @card({{__('base::attributes.subscription.show')}})
        <?= Details::generate($model, [
            
        ])?>
    @endcard
@endsection
