<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyCodeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'tel' => 'required|regex:/^[1]([3-9])[0-9]{9}$/',
        ];
    }

    public function attributes()
    {
        return [
            'tel' => '手机号',
        ];
    }

    public function messages()
    {
        return [
            'tel.required' => '手机号不能为空。',
        ];
    }
}
