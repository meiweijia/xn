<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    use ApiResponse;

    /**
     * 参数检查
     *
     * @param Request $request
     * @param array $param
     *
     * @throws InvalidRequestException
     */
    public function checkPar(Request $request, array $param)
    {
        $validator = Validator::make($request->all(), $param);
        if ($validator->fails()) {
            throw new InvalidRequestException($validator->errors());
        }
    }
}
