<?php

namespace App\Http\Controllers;

use App\Models\RegetCard;
use Illuminate\Http\Request;

class RegetCardController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }
    
    public function index(Request $request)
    {
        $this->setWith('house');
        return parent::index($request);
    }

    public function store(Request $request)
    {
        $result = $request->user()->regetCards()->create($request->only([
            'house_id',
            'number',//'补卡数量
            'images',//'身份证
        ]));
        return $this->success($result);
    }
}
