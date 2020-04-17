@php
use Capmega\Base\Widgets\Information\{BreadCrumb};
use Capmega\Base\Widgets\Messages\Error;
@endphp

@extends('base::layouts.main')

@section('title_tab', __('base::attributes.subscription.create'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'subscription.index' => __('base::attributes.subscription.items'),
        'Active'    => __('base::attributes.subscription.create'),
        ]) ?>
@endsection

@section('content')
    @card({{__('base::attributes.subscription.create')}})

    <?= Error::generate($errors) ?>    <form action="{{route('subscription.store')}}" method="post">
        @csrf
        @include('subscription._form')
    </form>
    @endcard
@endsection
