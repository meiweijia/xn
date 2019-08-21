<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\HouseOut;
use Illuminate\Http\Request;

class HouseOutController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }

    public function index(Request $request)
    {
        $this->setWith('house.layout.category');
        return parent::index($request);
    }

    public function store(Request $request)
    {
        $house = $request->user()->house()->first();
        $data = $request->only([
            'bathroom',//卫浴区 1正常 2有损 3有污渍 4严重损坏
            'parlour',//客厅区 1正常 2有损 3有污渍 4严重损坏
            'kitchen',//厨房区 1正常 2有损 3有污渍 4严重损坏
            'bedroom',//卧室区 1正常 2有损 3有污渍 4严重损坏
            'images',//照片
        ]);
        $data['house_id'] = $house->id;
        $result = $request->user()->houseOuts()->create($data);
        return $this->success($result);
    }

    public function update(Request $request, $id)
    {
        $result = HouseOut::query()
            ->where('id', $id)
            ->update($request->only([
                'start_time',
                'end_time',
                'leave_time',
            ]));
        return $this->success($result);
    }

    protected function approve(Request $request, $id)
    {
        $approve = $request->input('approve');
        $in = HouseOut::query()->find($id);
        $in->approve = $approve;
        $result = $in->save();
        if ($approve == 1) {
            House::query()->where('id', $in->house_id)->update([
                'user_id' => null,
                'status' => 1
            ]);
        }
        return $this->success($result);
    }
}
