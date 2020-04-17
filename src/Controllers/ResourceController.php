<?php

namespace Capmega\Base\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ResourceController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $model         = '';
    protected $view          = '';
    protected $resource      = '';
    protected $key           = 'seoname';
    protected $createEmpty   = false;
    protected $filters       = ['pagination' => '20'];
    protected $ignore        = ['page', 'pagination', 'order'];
    protected $default_order = false;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new $this->model();

        if (!$request->input('status')) {
            $models = $this->model::where($model->getTable().'.status', '!=', $this->model::STATUS_DELETE)
            ->where($model->getTable().'.status', '!=',$this->model::STATUS_CREATE);
        }else{
            $models = $this->model::where($model->getTable().'.id', '>', '0');
        }

        $models = $models->where($model->getTable().'.status', '!=' ,'0');

        $models   = Self::getOrder($models, $request->get('order'));
        if ($request->input('pagination')) {
            $this->filters['pagination'] = $request->input('pagination');
        }
        $models   = Self::setFilter($models, $request);
        $models   = $models->paginate($this->filters['pagination'])->appends($this->filters);

        return view($this->view . '.index', compact('models', 'model'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->createEmpty) {
            $model = $this->createOrFind();
        }else{
            $model = new $this->model();
        }
        return view($this->view . '.create', compact('model'));
    }

    protected function createOrFind($params = [])
    {
        $model = $this->model::where('created_by', \Auth::user()->id)
        ->where('status', $this->model::STATUS_CREATE)
        ->first();

        if (!$model) {
            if ($this->createEmpty) {
                $model = new $this->model();
                if ($model->hasColumn('created_by')) {
                    $model->created_by = \Auth::user()->id;
                }
                foreach ($params as $key => $value) {
                    $model->$key = $value;
                }
                $model->save();

                return $model;
            }
            return new $this->model();
        }

        return $model;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view($this->view . '.show', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view($this->view . '.edit', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->findModel($id);
        $model->status = $this->model::STATUS_DELETE;
        $model->save();

        return redirect()->route($this->resource . '.index');
    }

    /**
     * Find one model or 404
     *
     * @param  int  $id
     */
    protected function findModel($id, $attribute = null)
    {
        $model = $this->model::where($attribute??$this->key, $id)->first();

        if (!$model) {
            abort(404, 'base::messages.not_found');
        }

        return $model;
    }

    protected function loadData(&$model, $request)
    {
        foreach ($model->getTableColumns() as $key => $value) {
            if (!empty($request->input($model->getTable().'_'.$value)) || $request->input($model->getTable().'_'.$value) == '0') {
                $model->$value = $request->input($model->getTable().'_'.$value);
            }
        }
    }

    protected function loadDataAttributes(&$model, $request)
    {
        foreach ($model->attributes() as $key => $value) {
            if (!empty($request->input($model->getTable().'_'.$key))) {
                $model->$key = $request->input($model->getTable().'_'.$key);
            }
        }
    }

    protected function getOrder($searchModel, $order)
    {
        $model = new $this->model;

        if (empty($order) and $this->default_order) {
            $order = $this->default_order;
        }

        if($model->hasAttribute(str_replace('-', '', $order))){
            if( strpos( $order, '.' ) !== false){
                $order = explode('.', $order);

                $searchModel->with(\str_replace('-', '', $order['0']));
                if( strpos( $order['0'], '-' ) !== false){
                    $order = '-'.$order[1];
                }else{
                    $order = $order[1];
                }
            }

            if( strpos( $order, '-' ) !== false){
                $this->filters['order'] = $order;
                return $searchModel->orderBy(str_replace('-', '', $order), 'ASC');
            }else{
                $this->filters['order'] = '-' . $order;
                return $searchModel->orderBy($order, 'DESC');
            }
        }

        return $searchModel;
    }

    protected function setFilter($models, $request)
    {
        $model = new $this->model();
        $params = $request->all();
        foreach ($this->ignore as $key => $value) {
            unset($params[$value]);
        }

        if($params){
            foreach($params as $parameter => $value) {
                if(!empty($value)){
                    $table = $model->getTable();
                    $parameter = str_replace('-', ' ',$parameter);
                    $filter = $model->getFilter($parameter);
                    if($filter){
                        if(isset($filter['join'])){
                            if(\is_array($model->filters[$parameter]['join'])){
                                $table = $model->filters[$parameter]['join']['table'];
                            }else{
                                $table = $model->filters[$parameter]['join'];
                            }

                            $models = $models->join(
                                $table,
                                $model->filters[$parameter]['join']['local_key']??$table.'_id',
                                '=',
                                $model->filters[$parameter]['join']['foreign_key']??$table.'.id');
                        }

                        if(\is_array($filter['column']??false)) {
                            $models = $models->where(function($query) use ($model, $value, $parameter){
                                    foreach ($model->filters[$parameter]['column'] as $colum) {
                                        $query->orWhere($colum, 'like', '%'.$value.'%');
                                    }
                             });
                        }else{
                            switch($filter['type']??'like'){
                                case 'like':
                                $models = $models->where($table.'.'.($filter['column']??$filter), 'like' , '%'.$value.'%');
                                break;

                                case 'equal':
                                case 'dropdown':
                                $models = $models->where($table.'.'.($filter['column']??(is_array($filter)?$parameter:$filter)), '=' ,$value);
                                break;

                                case 'date_less':
                                case 'minimum':
                                $models = $models->whereDate($table.'.'.($filter['column']??(is_array($filter)?$parameter:$filter)), '>=', $value);
                                break;

                                case 'date_higher':
                                case 'maximum':
                                $models = $models->whereDate($table.'.'.($filter['column']??(is_array($filter)?$parameter:$filter)), '<=', $value);
                                break;
                            }
                        }

                    }
                }
                $this->filters[$parameter] = $value;
            }
        }

        return $models;
    }

    protected function validate(Request $request, string $rules = 'rules', $options = [], $model = false)
    {
        if (!$model) {
            $model     = new $this->model;
        }
        $params    = $model::getParseRequest($model, $request->all());
        $rules     = $model::getParseRules($model, $model::$rules($options));
        $validator = Validator::make($params, $rules, $model->getMessages())->validate();

        return $validator;
    }
}
