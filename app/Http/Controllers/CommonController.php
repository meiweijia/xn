<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends ApiController
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $result = url('storage') . '/' . $request->file('file')->store('images/upload', 'public');
            return $this->success($result,'上传成功！');
        }
        return $this->error([],'文件上传失败！');
    }
}
