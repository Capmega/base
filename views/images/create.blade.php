@php
use Capmega\Base\Widgets\Information\{BreadCrumb};
use Capmega\Base\Widgets\Messages\Error;
@endphp

@extends('base::layouts.main')

@section('title_tab', __('base::attributes.images.create'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'images.index' => __('base::attributes.images.items'),
        'Active'    => __('base::attributes.images.create'),
        ]) ?>
@endsection

@section('content')
    @card({{__('base::attributes.images.create')}})

    <?= Error::generate($errors) ?>
    <form action="{{route('images.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        @include('base::images._form')
    </form>
    @endcard
@endsection
