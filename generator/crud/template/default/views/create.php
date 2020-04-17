@php
use Capmega\Base\Widgets\Information\{BreadCrumb};
use Capmega\Base\Widgets\Messages\Error;
@endphp

@extends('base::layouts.main')

@section('title_tab', __('<?=$this->translate?>.create'))

@section('breadcrumb')
    <?='<?= BreadCrumb::generate([
        \''.$this->resource.'.index\' => __(\''.$this->translate.'.items\'),
        \'Active\'    => __(\''.$this->translate.'.create\'),
        ]) ?>'?>

@endsection

@section('content')
    @card(<?='{{__(\''.$this->translate.'.create\')}}'?>)

    <?='<?= Error::generate($errors) ?>'?>
    <form action="{{route('<?=$this->resource?>.store')}}" method="post">
        @csrf
        @include('<?=$this->view?>._form')
    </form>
    @endcard
@endsection
