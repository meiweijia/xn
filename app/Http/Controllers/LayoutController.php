<?php

namespace App\Http\Controllers;

use App\Models\Layout;
use Illuminate\Http\Request;

class LayoutController extends ApiController
{
    public function index(Request $request)
    {
        $this->checkPar($request, [
            'category_id' => 'required'
        ]);
        $category_id = $request->input('category_id');
        $result = Layout::query()
            ->where('category_id', $category_id)
            ->get();
        return $this->success($result);
    }

    public function show(Request $request, $id)
    {
        $layout = Layout::query()
            ->with('category')
            ->find($id);
        return $this->success($layout);
    }
}
