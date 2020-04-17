<?php
namespace Capmega\Base\Controllers;

use Illuminate\Http\Request;
use Capmega\Base\Controllers\ResourceController;
use Capmega\Base\Models\Subscription;
use Capmega\Base\Exports\SubscriptionExport;
use Maatwebsite\Excel\Facades\Excel;

/**
 * [class description]
 */
class SubscriptionController extends ResourceController
{
    protected $model    = '\Capmega\Base\Models\Subscription';
    protected $view     = 'base::subscription';
    protected $resource = 'subscription';
    protected $key      = 'id';

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

    public function addEmail(Request $request)
    {
        $email = Subscription::where('email', $request->input('email'))->first();
        if (!$email) {
            $email = new Subscription();
            $email->status = Subscription::STATUS_ACTIVE;
            $email->email = $request->input('email');
            $email->save();
        }

        return response()->json([
            'alert' => 'success',
            'message' => $request->input('email') . ' We\'ll send you some news'
        ]);
    }

    public function csv()
    {
        return Excel::download(new SubscriptionExport, 'subscriptions.csv');
    }
}
