<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends ApiController
{
    public function store(Request $request)
    {
        $result = Tenant::query()->create($request->only([
            'house_id',
            'name',//姓名
            'id_card',//身份证号码
            'id_card_images',//身份证图片
            'tel',//电话
        ]));
        return $this->success($result);
    }
}
