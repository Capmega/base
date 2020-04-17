@php
use Capmega\Base\Widgets\Information\BreadCrumb;
use Capmega\Base\Widgets\Messages\Alert;
use Capmega\Base\Widgets\Form\ActiveField;
use Capmega\Base\Widgets\Messages\Error;
@endphp
@extends('base::layouts.main')

@section('title_tab', __('base::app.common_config'))

@section('breadcrumb')
    <?= BreadCrumb::generate([
        'Active'    => __('base::app.common_config'),
        ]) ?>
@endsection

@section('content')
    @card({{__('base::app.common_config')}})
        <?= Error::generate($errors) ?>

        <div class="div">
            <div class="form-group">
                <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#large">
                    @lang('base::messages.add_attribute')
                </button>

                <div class="modal fade text-left" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel17">@lang('base::messages.attributes')</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <label>@lang('base::messages.attribute')</label>
                                            <input type="text" name="attribute" class="form-control">
                                        </div>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th>@lang('base::messages.attribute')</th>
                                            <th>@lang('base::messages.menu')</th>
                                        </tr>
                                        @foreach ($model->getDefaultKeys() as $key => $value)
                                            <tr>
                                                <td>{{$value['name']}}</td>
                                                <td>
                                                    <button type="submit" value="{{$key}}" name="type" class="btn btn-danger">
                                                        <i class="la la-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">@lang('base::messages.close')</button>
                                    <button name="type" value="new" type="submit" class="btn btn-outline-primary">@lang('base::messages.save')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form enctype="multipart/form-data" action="{{route('configuration.general')}}" method="post">
            @csrf

            <?= ActiveField::Input($model, '')->keyValues($model->getDefaultKeys()) ?>

            <div class="form-group row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">@lang('base::messages.save')</button>
                </div>
            </div>
        </form>
    @endcard
@endsection
