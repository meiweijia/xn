<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\House;
use Illuminate\Http\Request;

class IndexController extends ApiController
{
    public function index()
    {
        $result['banner'] = [];
        $result['category'] = Category::query()
            ->get();
        $result['apartment'] = House::query()
            ->where('recommend', 1)
            ->paginate(10);
        return $this->success($result);
    }

    public function houses(Request $request)
    {
        $this->checkPar($request,[
            'type_id' => 'required',
        ]);
        $type_id = $request->input('type_id');
        $result = Category::query()
            ->with('houses')
            ->where('type', $type_id)
            ->get();
        return $this->success($result);
    }
}
