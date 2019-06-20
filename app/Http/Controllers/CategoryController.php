<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Region;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function index(Request $request)
    {
        $this->checkPar($request, [
            'type' => 'required',
        ]);

        $type = $request->input('type');
        $result = Category::query()
            ->where('type', $type)
            ->get();
        return $this->success($result);
    }

    public function show(Category $category)
    {
        return $this->success($category);
    }
}
