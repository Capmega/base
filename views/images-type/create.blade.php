@php
use Capmega\Base\Widgets\Information\{BreadCrumb};
use Capmega\Base\Widgets\Messages\Error;
@endphp

@extends('base::layouts.main')

@section('title_tab', __('base::attributes.images-type.create'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'images-type.index' => __('base::attributes.images-type.items'),
        'Active'    => __('base::attributes.images-type.create'),
        ]) ?>
@endsection

@section('content')
    @card({{__('base::attributes.images-type.create')}})

    <?= Error::generate($errors) ?>
    <form action="{{route('images-type.store')}}" method="post">
        @csrf
        @include('base::images-type._form')
    </form>
    @endcard
@endsection
