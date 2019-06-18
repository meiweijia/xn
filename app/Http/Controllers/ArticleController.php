<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends ApiController
{
    public function store(Request $request)
    {
        $result = Article::query()->create($request->only([
            'title',//标题
            'content',//内容
            'images',//图片
        ]));
        return $this->success($result);
    }
}
