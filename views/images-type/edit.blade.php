@php
use Capmega\Base\Widgets\Information\BreadCrumb;
use Capmega\Base\Widgets\Form\ActiveField;
use Capmega\Base\Widgets\Messages\Error;
@endphp

@extends('base::layouts.main')

@section('title_tab', __('base::attributes.images-type.edit'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'images-type.index' => __('base::attributes.images-type.items'),
        'Active'    => __('base::attributes.images-type.edit'),
        ]) ?>
@endsection

@section('content')
    @card({{__('base::attributes.images-type.edit')}})
        <?= Error::generate($errors) ?>
        <form action="{{route('images-type.update', $model->seoname)}}" method="post">
            @csrf
            @method('PUT')
            @include('base::images-type._form')
        </form>
    @endcard
@endsection
