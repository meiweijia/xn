<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    use ApiResponse;

    protected function index(Request $request)
    {
        $approve = $request->input('approve');
        $model = $this->getInstance($request);
        $result = $model
            ->when($approve, function ($query, $approve) {
                $query->where('approve', $approve);
            })
            ->paginate(20);
        return $this->success();
    }

    protected function show(Request $request, $id)
    {
        $model = $this->getInstance($request);
        return $this->success($model->findOrFail($id));
    }

    protected function approve(Request $request, $id)
    {
        $approve = $request->input('approve');
        $model = $this->getInstance($request);
        $result = $model->where('id', $id)->update([
            'approve' => $approve
        ]);
        return $this->success($result);
    }

    /**
     * 参数检查
     *
     * @param Request $request
     * @param array $param
     *
     * @throws InvalidRequestException
     */
    protected function checkPar(Request $request, array $param)
    {
        $validator = Validator::make($request->all(), $param);
        if ($validator->fails()) {
            throw new InvalidRequestException($validator->errors());
        }
    }

    /**
     * 获取控制器对应的 model
     *
     * @param $request
     *
     * @return string
     */
    private function getClass($request)
    {
        $action = $request->route()->getActionName();
        list($class, $method) = explode('@', $action);
        $class = '\\App\Models\\' . str_replace('Controller', '', class_basename($class));
        return $class;
    }

    /**
     * 获取控制器对应的 model 的实例
     *
     * @param $request
     *
     * @return Builder
     */
    private function getInstance($request)
    {
        $class = $this->getClass($request);
        return new $class();
    }
}
