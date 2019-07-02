<?php

namespace App\Http\Controllers;

use App\Models\Renew;
use Illuminate\Http\Request;

class RenewController extends ApiController
{

    public function index(Request $request)
    {
        $this->setWith('house');
        return parent::index($request);
    }

    public function store(Request $request)
    {
        $result = Renew::query()->create($request->only([
            'house_id',
            'contract_old',//旧合同第一页
            'contract_new',//新合同第一页
            'recovery',//收回
        ]));
        return $this->success($result);
    }
}
