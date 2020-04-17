<?php
namespace Capmega\Base\Controllers;

use Illuminate\Http\Request;
use Capmega\Base\Controllers\ResourceController;
use Illuminate\Support\Facades\{Validator, Hash, Auth};
use Illuminate\Support\Str;
use App\User;
use Capmega\Blog\Models\BlogPost;

class ConfigurationController extends ResourceController
{
    public function general(Request $request)
    {
        $method = $request->method();
        $model  = BlogPost::where('id', '1')->first();

        if ($request->isMethod('post')) {
            $all = $request->all();
            if (isset($all['type'])) {
                $attributes = $model->getDefaultKeys();

                if ($all['type'] == 'new') {
                    array_push($attributes, [
                        'name'        => $all['attribute'],
                        'seoname'     => $all['attribute'],
                        'type'        => '',
                        'values'      => '',
                        'category'    => 'Contact',
                        'seocategory' => 'contact'
                    ]);
                    $model->keys = serialize($attributes);
                    $model->save();
                }else{
                    array_splice($attributes, $all['type'], 1);
                    $model->keys = serialize($attributes);
                    $model->save();
                }

            }else{
                foreach ($all as $key => $value) {
                    if (strpos($key, $model->getTable().'_bkeys_') === 0) {
                        $key = str_replace($model->getTable().'_bkeys_', '', $key);
                        $model->saveKey($key, $value);
                    }
                }
            }
            return redirect()->route('configuration.general');
        }

        return view('base::configuration.general', [
            'model' => $model
        ]);
    }
}
