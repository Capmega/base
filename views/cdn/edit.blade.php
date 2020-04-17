@php
use Capmega\Base\Widgets\Information\BreadCrumb;
use Capmega\Base\Widgets\Form\ActiveField;
use Capmega\Base\Widgets\Messages\Error;
@endphp

@extends('base::layouts.main')

@section('title_tab', __('base::attributes.cdn.edit'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'cdn.index' => __('base::attributes.cdn.items'),
        'Active'    => __('base::attributes.cdn.edit'),
        ]) ?>
@endsection

@section('content')
    @card({{__('base::attributes.cdn.edit')}})
        <?= Error::generate($errors) ?>
        <form action="{{route('cdn.update', $model->id)}}" method="post">
            @csrf
            @method('PUT')
            @include('base::cdn._form')
        </form>
    @endcard
@endsection
