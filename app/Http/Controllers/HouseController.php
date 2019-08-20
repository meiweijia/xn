<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class HouseController extends ApiController
{
    public function index(Request $request)
    {
        $this->checkPar($request, [
            'category_id' => 'required'
        ]);
        $category_id = $request->input('category_id');
        $result = House::query()
            ->where('category_id', $category_id)
            ->get();
        return $this->success($result);
    }

    public function tenants(House $house)
    {
        return $this->success($house->tenants()->get());
    }
}
