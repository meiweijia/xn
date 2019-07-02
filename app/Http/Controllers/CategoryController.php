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
        $result = Category::query()
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->get();
        return $this->success($result);
    }
}
