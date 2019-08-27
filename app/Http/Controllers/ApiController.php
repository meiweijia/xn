<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\Category;
use App\Models\House;
use App\Models\Layout;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    use ApiResponse;

    /**
     * @var Builder
     */
    protected $model;

    /**
     * @var string | array
     *
     */
    protected $with = null;

    protected function index(Request $request)
    {
        $approve = $request->input('approve');//审批
        $this->model = $this->getInstance($request);
        $result = $this->model
            ->when($this->with, function ($query) {
                $query->with($this->with);
            })
            ->when($approve, function ($query, $approve) {
                $query->where('approve', $approve);
            })
            ->orderByDesc('created_at')
            ->paginate(20);
        return $this->success($result);
    }

    protected function indexAdmin(Request $request)
    {
        $this->model = $this->getInstance($request);
        $par = '';
        if ($this->model instanceof Category) {
            $par = 'region_id';
        }
        if ($this->model instanceof House) {
            $par = 'category_id';
        }
        $q = $request->input('q');//后台 select 联动需要
        if (!$q || !$par) {
            return [];
        }
        return $this->model
            ->where($par, $q)
            ->get();
    }

    protected function show(Request $request, $id)
    {
        $model = $this->getInstance($request);
        return $this->success($model->findOrFail($id));
    }

    protected function approve(Request $request, $id)
    {
        $approve = $request->input('approve');
        $instance = $this->getInstance($request);
        $model = $instance->find($id);
        $model->approve = $approve;
        $result = $model->save();
        return $this->success($result);
    }

    /**
     * @param mixed $with
     */
    protected function setWith($with = null): void
    {
        $this->with = $with;
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
