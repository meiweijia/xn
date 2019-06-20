<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends ApiController
{
    public function index(Request $request)
    {
        $this->checkPar($request, [
            'type' => 'required',
        ]);

        $type = $request->input('type');
        $result = Region::query()
            ->with(['categories' => function ($query) use ($type) {
                $query->where('type', $type);
            }])
            ->get();
        return $this->success($result);
    }

    public function show(Region $region)
    {
        return $this->success($region);
    }
}
