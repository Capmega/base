<?php

namespace Capmega\Base\Controllers;

use Illuminate\Http\Request;
use Capmega\Base\Controllers\ResourceController;
use Capmega\Base\Traits\SizeModel;

/**
 * [class description]
 */
class ImagesTypeController extends ResourceController
{
    protected $model       = '\Capmega\Base\Models\ImageType';
    protected $view        = 'base::images-type';
    protected $resource    = 'images-type';
    protected $createEmpty = true;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = $this->createOrFind();
        if (!$model->sizes) {
            $model->sizes = serialize(config('base.images'));
            $model->save();
        }

        return view($this->view . '.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request);

        $model = $this->createOrFind();
        $model->status = $this->model::STATUS_ACTIVE;
        $this->loadData($model, $request);
        $model->created_by = \Auth::user()->id;

        $model->save();

        return redirect()->route($this->resource . '.index')->with('success', __('base::messages.saved'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request);

        $model = $this->findModel($id);
        $this->loadData($model, $request);

        $model->save();

        return redirect()->route($this->resource . '.index')->with('success', __('base::messages.saved'));
    }

    use SizeModel;
}
