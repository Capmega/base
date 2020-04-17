@php
use Capmega\Base\Widgets\Information\{BreadCrumb};
use Capmega\Base\Widgets\Messages\Error;
@endphp

@extends('base::layouts.main')

@section('title_tab', __('base::attributes.cdn.create'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'cdn.index' => __('base::attributes.cdn.items'),
        'Active'    => __('base::attributes.cdn.create'),
        ]) ?>
@endsection

@section('content')
    @card({{__('base::attributes.cdn.create')}})

    <?= Error::generate($errors) ?>
    <form action="{{route('cdn.store')}}" method="post">
        @csrf
        @include('base::cdn._form')
    </form>
    @endcard
@endsection
