<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'tel' => 'required|regex:/^[1]([3-9])[0-9]{9}$/|unique:users,tel',
                    'password' => 'required|string|min:6',
                    'verification_code' => 'required|string',
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
            'verification_code' => '短信验证码',
            'tel' => '手机号',
        ];
    }

    public function messages()
    {
        return [
            'tel.unique' => '该手机已经注册，请重新填写',
            'tel.regex' => '请输入正确的手机号',
            'tel.required' => '手机号不能为空。',
        ];
    }
}
