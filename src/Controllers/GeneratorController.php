<?php

namespace Capmega\Base\Controllers;

use Illuminate\Http\Request;
use Capmega\Base\Controllers\ResourceController;
use Capmega\Base\Models\Generator\{Crud, Model};

class GeneratorController extends ResourceController
{
    private $template;
    protected $model = 'Capmega\Base\Models\Generator\Crud';

    /**
     * Show interface to generate one model.
     *
     */
    public function model(Request $request)
    {
        $this->template = base_path().'/vendor/capmega/base/generator/crud/template/default/';

        $model = new Model();

        if ($request->isMethod('post')) {
            $this->validate($request);
            $this->loadDataAttributes($model, $request);

            try {
                $model->generate($this->template);
                return redirect()->route('generator.model')->with('success', __('base::messages.saved'));
            } catch (\Exception $e) {
            }

        }

        return view('base::generator.model', [
            'model' => $model
        ]);
    }

    /**
     * Show interface to generate one model.
     *
     */
    public function crud(Request $request)
    {
        $this->template = base_path().'/vendor/capmega/base/generator/crud/template/default/';
        $model = new Crud();
        $model->model          = '\\App\\Models\\';
        $model->name_space     = 'App\\Http\\Controllers\\';
        $model->location_path  = base_path().'/app/Http/Controllers/';
        $model->view_path      = base_path().'/resources/views/';
        $model->route_path     = base_path().'/routes/web';
        $model->translate      = 'attributes.';
        $model->translate_path = base_path().'/resources/lang';

        if ($request->isMethod('post')) {
            $this->validate($request);
            $this->loadDataAttributes($model, $request);

            try {
                $model->generate($this->template);
                return redirect()->route('generator.crud')->with('success', __('base::messages.saved'));
            } catch (\Exception $e) {
                return redirect()->route('generator.crud')->withErrors(['Class not exist'])->withInput();
            }
        }

        return view('base::generator.crud', [
            'model' => $model
        ]);
    }
}
