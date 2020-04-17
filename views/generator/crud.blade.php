@php
use Capmega\Base\Widgets\Information\BreadCrumb;
use Capmega\Base\Widgets\Form\ActiveField;
use Capmega\Base\Widgets\Messages\{Error, Alert};
@endphp

@extends('base::layouts.main')

@section('title_tab', __('base::generator.make_crud'))

@section('content')
    @card({{__('base::generator.make_crud')}})
    <?= Alert::generate() ?>
    <?= Error::generate($errors) ?>
    <form action="" method="post">
        @csrf
        <div class="row form-group">
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'model')?>
            </div>
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'resource')->textInput(['id' => 'resource'])?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'name_space')->textInput(['id' => 'name_space'])?>
            </div>
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'location_path')?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'view')->textInput(['id' => 'view'])?>
            </div>
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'view_path')?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'route')->textInput(['id' => 'route'])?>
            </div>
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'route_path')?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'translate')->textInput(['id' => 'translate'])?>
            </div>
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'translate_path')?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <?= ActiveField::Input($model, 'key')?>
            </div>
        </div>

        <div class="form-group row">
            <br>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">@lang('base::messages.save')</button>
            </div>
        </div>
    </form>
    @endcard()
@endsection
