<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Region;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function index(Request $request)
    {
        $type = $request->input('type');
        $q = $request->input('q');//后台 select 联动需要
        $result = Category::query()
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when($q, function ($query) use ($q) {
                $query->where('region_id', $q);
            })
            ->get();
        return $this->success($result);
    }
}
