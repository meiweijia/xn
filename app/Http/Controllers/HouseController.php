<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class HouseController extends ApiController
{
    public function index(Request $request)
    {
        $this->checkPar($request, [
            'layout_id' => 'required'
        ]);
        $layout_id = $request->input('layout_id');
        $result = House::query()
            ->where('layout_id', $layout_id)
            ->get();
        return $this->success($result);
    }

    public function tenants(House $house)
    {
        return $this->success($house->tenants()->get());
    }
}
