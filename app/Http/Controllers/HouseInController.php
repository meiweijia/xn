<?php

namespace App\Http\Controllers;

use App\Models\HouseIn;
use Illuminate\Http\Request;

class HouseInController extends ApiController
{

    public function index(Request $request)
    {
        $this->setWith(['house', 'house.layout']);
        return parent::index($request);
    }

    public function store(Request $request)
    {
        $result = HouseIn::query()->create($request->only([
            'house_id',
            'rent',//租金
            'deposit',//押金
            'start_time',//起租日期
            'end_time',//截止日期
            'peoples',//入住人数
            'names',//全部入住人姓名
            'id_card_images',//身份证图片
            'phone',//签约人电话
            'status',//'验收 1已验收 0未验收
            'electric_number',//电表度数
            'cold_water_number',//冷水表度数
            'hot_water_number',//热水表度数
        ]));
        return $this->success($result);
    }
}
