<?php
namespace Capmega\Base\Traits;

use Illuminate\Http\Request;

/**
 *
 */
trait SizeModel
{
    public function addSize(String $id, Request $request)
    {
        $model = $this->findModel($id, 'id');

        $sizes = $model->sizes;

        array_push($sizes, [
            'name'         => $request->post('name'),
            'height'       => $request->post('height'),
            'width'        => $request->post('width'),
            'quality'      => (int) $request->post('quality'),
            'transparency' => $request->post('transparency'),
            'resizing'     => $request->post('resizing'),
        ]);

        $model->sizes = serialize($sizes);
        $model->save();

        return response()->json([
        ]);
    }

    public function removeSize($id, Request $request)
    {
        $model = $this->findModel($id, 'id');

        $sizes = $model->sizes;
        array_splice($sizes, $request->post('index'), 1);
        $model->sizes = serialize($sizes);
        $model->save();

        return response()->json([
        ]);
    }
}
