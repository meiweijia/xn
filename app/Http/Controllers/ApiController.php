<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $class = $this->getClass($request);
        $model = new $class;
        return $this->success($model->paginate(20));
    }

    public function approve(Request $request, $id)
    {
        $approve = $request->input('approve');
        $class = $this->getClass($request);
        $model = new $class;
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
    public function checkPar(Request $request, array $param)
    {
        $validator = Validator::make($request->all(), $param);
        if ($validator->fails()) {
            throw new InvalidRequestException($validator->errors());
        }
    }

    private function getClass($request)
    {
        $action = $request->route()->getActionName();
        list($class, $method) = explode('@', $action);
        $class = '\\App\Models\\' . str_replace('Controller', '', class_basename($class));
        return $class;
    }
}
