@php
use Capmega\Base\Widgets\Grid\Details;
use Capmega\Base\Widgets\Information\BreadCrumb;
@endphp
@extends('base::layouts.main')

@section('title_tab', __('<?=$this->translate?>.show'))

@section('breadcrumb')
    <?='<?= BreadCrumb::generate([
        \''.$this->resource.'.index\' => __(\''.$this->translate.'.items\'),
        \'Active\'    => __(\''.$this->translate.'.show\'),
        ]) ?>'?>

@endsection

@section('content')

    @card(<?='{{__(\''.$this->translate.'.show\')}}'?>)
        <?php
        $attributes = '';
        foreach ($this->new_model->getTableColumns() as $key => $value){
            if ($value == 'created_by') {
                // code...
            }else{
            $attributes .= '\''.$value.'\',
            ';
            }
        }
        ?>
<?='<?= Details::generate($model, [
            '.$attributes.'
        ])?>'?>

    @endcard
@endsection
