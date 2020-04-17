@php
use Capmega\Base\Widgets\Information\BreadCrumb;
use Capmega\Base\Widgets\Form\ActiveField;
use Capmega\Base\Widgets\Messages\Error;
@endphp

@extends('base::layouts.main')

@section('title_tab', __('<?=$this->translate?>.edit'))

@section('breadcrumb')
    <?='<?= BreadCrumb::generate([
        \''.$this->resource.'.index\' => __(\''.$this->translate.'.items\'),
        \'Active\'    => __(\''.$this->translate.'.edit\'),
        ]) ?>'?>

@endsection

@section('content')
    @card(<?='{{__(\''.$this->translate.'.edit\')}}'?>)
    <?php
        $key = $this->key??'seoname';
    ?>
    <?='<?= Error::generate($errors) ?>'?>
    <form action="{{route('<?=$this->resource?>.update', $model-><?=$key?>)}}" method="post">
        @csrf
        @method('PUT')
        @include('<?=$this->view?>._form')
    </form>
    @endcard
@endsection
