<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyCodeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Facades\EasySms;

class UserController extends ApiController
{
    public function register(UserRequest $request)
    {
        $verifyData = Cache::get($request->tel);

        if (!$verifyData) {
            return $this->error([], '验证码已失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            return $this->error([], '验证码错误');
        }

        $user = User::query()->create([
            'tel' => $request->tel,
            'password' => bcrypt($request->password),
            'name' => '',
            'email' => '',
        ]);

        return $this->success($user, '注册成功！');

    }

    /**
     * 处理身份验证尝试。
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function login(Request $request)
    {
        $credentials = $request->only('tel', 'password');

        if (Auth::attempt($credentials)) {
            // 身份验证通过...
            $user = User::query()->find(Auth::id());
            $user->update(['api_token'=>Str::random(80)]);
            return $this->success($user, '登录成功！');
        }

        return $this->error([], '账号或密码错误，登录失败！');
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        if (!app()->environment('production')) {
            $code = '1234';
        } else {
            // 生成4位随机数，左侧补0
            $code = generate_code();

            try {
                EasySms::send($request->tel, [
                    'content' => '您的验证码为: ' . $code,
                    'template' => 'SMS_129070037',
                    'data' => [
                        'code' => $code
                    ],
                ]);

            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException(config('easysms')['default']['gateways'][0])->getMessage();
                return $this->error([], $message ?? '短信发送异常');
            }
        }

        $expiredAt = now()->addMinutes(10);
        // 缓存验证码 10分钟过期。
        \Cache::put($request->tel, ['code' => $code], $expiredAt);

        return $this->success([
            'expired_at' => $expiredAt->toDateTimeString(),
        ]);
    }
}
