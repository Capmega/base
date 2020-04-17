@php
use Capmega\Base\Widgets\Information\BreadCrumb;
use Capmega\Base\Widgets\Form\ActiveField;
use Capmega\Base\Widgets\Messages\Error;
@endphp

@extends('base::layouts.main')

@section('title_tab', __('base::attributes.images.edit'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'images.index' => __('base::attributes.images.items'),
        'Active'    => __('base::attributes.images.edit'),
        ]) ?>
@endsection

@section('content')
    @card({{__('base::attributes.images.edit')}})
        <?= Error::generate($errors) ?>
        <form action="{{route('images.update', $model->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('base::images._form')
        </form>
    @endcard
@endsection
