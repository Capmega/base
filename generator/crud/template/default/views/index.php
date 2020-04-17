@php
use Capmega\Base\Widgets\Grid\GridView;
use Capmega\Base\Widgets\Information\{BreadCrumb};
use Capmega\Base\Widgets\Messages\Alert;
@endphp
@extends('base::layouts.main')

@section('title_tab', __('<?=$this->translate?>.items'))


@section('breadcrumb')
    <?='<?= BreadCrumb::generate([
        \'Active\'    => __(\''.$this->translate.'.items\'),
        ]) ?>'?>

@endsection

@section('content')

    @card(<?='{{__(\''.$this->translate.'.items\')}}'?>)
    <?='<div class="form-group">
        <a href="{{route(\''.$this->resource.'.create\')}}" class="btn btn-primary"> @lang(\''.$this->translate.'.create\') </a>
    </div>'?>

    <?= '<?= Alert::generate() ?>'?>

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
    $key = $this->key??'seoname';
    ?>
<?='<?= GridView::generate([
        \'model\' => $model,
        \'models\' => $models,
        \'route\' => \''.$this->resource.'\',
        \'key\' => \''.$key.'\',
        \'attributes\' => [
            '.$attributes.'
        ]
    ])?>
'?>
    @endcard
@endsection
