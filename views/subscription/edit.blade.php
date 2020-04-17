@php
use Capmega\Base\Widgets\Information\BreadCrumb;
use Capmega\Base\Widgets\Form\ActiveField;
use Capmega\Base\Widgets\Messages\Error;
@endphp

@extends('base::layouts.main')

@section('title_tab', __('base::attributes.subscription.edit'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'subscription.index' => __('base::attributes.subscription.items'),
        'Active'    => __('base::attributes.subscription.edit'),
        ]) ?>
@endsection

@section('content')
    @card({{__('base::attributes.subscription.edit')}})
        <?= Error::generate($errors) ?>    <form action="{{route('subscription.update', $model->id)}}" method="post">
        @csrf
        @method('PUT')
        @include('subscription._form')
    </form>
    @endcard
@endsection
