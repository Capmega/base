@php
use Capmega\Base\Widgets\Information\BreadCrumb;
use Capmega\Base\Widgets\Messages\{Error, Alert};
@endphp

@extends('base::layouts.main')

@section('title_tab', __('base::generator.make_model'))

@section('content')
    @card({{__('base::generator.make_model')}})
    <?= Alert::generate() ?>
    <?= Error::generate($errors) ?>
    <form action="" method="post">
        @csrf
    </form>
    @endcard()
@endsection
