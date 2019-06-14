<?php

namespace App\Http\Controllers;

use App\Models\Layout;
use Illuminate\Http\Request;

class LayoutController extends ApiController
{
    public function index(Request $request)
    {
        $this->checkPar($request, [
            'category_id'
        ]);
        $category_id = $request->input('category_id');
        $result = Layout::query()
            ->where('category_id', $category_id)
            ->get();
        return $this->success($result);
    }

    public function show(Layout $layout)
    {
        return $this->success($layout);
    }
}
