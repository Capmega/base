<?php

namespace Capmega\Base\Controllers;

use Illuminate\Http\Request;
use Capmega\Base\Controllers\ResourceController;
use Capmega\Base\Traits\SizeModel;

/**
 * [class description]
 */
class ImageController extends ResourceController
{
    protected $model       = '\Capmega\Base\Models\Image';
    protected $view        = 'base::images';
    protected $resource    = 'images';
    protected $key         = 'id';
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
     * Show the form for creating a multiples new resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function createMultiple(Request $request)
    {
        if ($request->isMethod('post')) {
            if($request->hasfile('images_image'))
            {
                foreach($request->file('images_image') as $file)
                {
                    $image = new $this->model();
                    // $extension = $file->getClientOriginalExtension();

                    $image->created_by     = \Auth::user()->id;
                    $image->extension      =  $file->extension();
                    $image->route          =  $request->input('images_route');
                    $image->name           =  $request->input('images_name')??str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName());
                    $image->alt            =  $request->input('images_alt');
                    $image->status         =  $this->model::STATUS_ACTIVE;
                    if ($request->input('images_image_types_id')) {
                        $image->image_types_id =  $request->input('images_image_types_id');
                    }
                    $image->save();

                    $file->storeAs('public/images', $request->input('images_route') . $image->seoname . '.' . $file->extension());
                    $image->convertImage();
                }
            }
            return redirect()->route($this->resource . '.index')->with('success', __('base::messages.saved'));
        }

        $model = new $this->model();

        return view($this->view . '.create-multiple', compact('model'));
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

        if($request->hasfile('images_image')){
            $file = $request->file('images_image');

            if (!$model->name) {
                $model->name =  str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName());
            }

            if (!$model->sizes) {
                $model->sizes = serialize(config('base.images'));
            }

            $model->extension =  $file->extension();
            $model->save();
            $file->storeAs('public/images', $request->input('images_route') . $model->seoname . '.' . $file->extension());
            $model->convertImage();
        }

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

        if($request->hasfile('images_image')){
            $file = $request->file('images_image');

            if (!$model->name) {
                $model->name =  str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName());
            }

            if (!$model->sizes) {
                $model->sizes = serialize(config('base.images'));
            }

            $model->extension =  $file->extension();
            $model->save();
            $file->storeAs('public/images', $request->input('images_route') . $model->seoname . '.' . $file->extension());
            $model->convertImage();
        }

        $model->save();

        return redirect()->route($this->resource . '.index')->with('success', __('base::messages.saved'));
    }

    use SizeModel;
}
