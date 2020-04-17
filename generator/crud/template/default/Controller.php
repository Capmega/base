<?= '<?php
' ?>
namespace <?=str_replace('\\'.$this->nameSpace, '', $this->name_space)?>;

use Illuminate\Http\Request;
use Capmega\Base\Controllers\ResourceController;

/**
 * [class description]
 */
class <?=$this->nameSpace?> extends ResourceController
{
    protected $model    = '<?=$this->model?>';
    protected $view     = '<?=$this->view?>';
    protected $resource = '<?=$this->resource?>';
    <?php if (isset($this->key)): ?>
protected $key      = '<?=$this->key?>';
    <?php endif; ?>

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
}
