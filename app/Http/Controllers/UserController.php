<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyCodeRequest;
use App\Models\House;
use App\Models\Layout;
use App\Models\Order;
use App\Models\RentLog;
use App\Services\WechatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Facades\EasySms;
use Spatie\Permission\Models\Role;

class UserController extends ApiController
{
    public function register(UserRequest $request, WechatService $wechatService)
    {
        $verifyData = Cache::get('verification_code_' . $request->tel);

        if (!$verifyData) {
            return $this->error([], '验证码已失效');
        }

        if (!hash_equals(strval($verifyData['code']), $request->verification_code)) {
            return $this->error([], '验证码错误');
        }

        $code = $request->input('code');
        $open_id = $wechatService->openid($code);
        if (!$open_id) {
            return $this->error([], 'code错误');
        }

        $user = User::query()->create([
            'tel' => $request->tel,
            'password' => bcrypt($request->password),
            'name' => '',
            'open_id' => $open_id,
        ]);

        //删除原来的验证码
        Cache::forget('verification_code_' . $request->tel);

        //注册成功 给予 guest 权限
        $user->assignRole('游客');
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
            $user->update(['api_token' => Str::random(80)]);
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
                    'template' => 'SMS_169365272',
                    'data' => [
                        'code' => $code
                    ],
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException(config('easysms')['default']['gateways'][0])->getMessage();
                return $this->error([], $message ?? '短信发送异常');
            }
        }

        $expiredAt = now()->addMinutes(5);
        // 缓存验证码 10分钟过期。
        Cache::put('verification_code_' . $request->tel, ['code' => $code], $expiredAt);

        return $this->success([
            'expired_at' => $expiredAt->toDateTimeString(),
        ]);
    }

    /**
     * 我的首页-游客会返回各种订单的个数
     *
     * @param Request $request
     *
     * @return array
     */
    public function index(Request $request)
    {
        $result['data'] = [];
        $result['role'] = Auth::user()->getRoleNames();
        if (Auth::user()->hasRole('guest')) {
            $pending = Order::query()->where('user_id', Auth::id())->where('status', Order::PAY_STATUS_PENDING)->count();
            $processing = Order::query()->where('user_id', Auth::id())->where('status', Order::PAY_STATUS_PROCESSING)->count();
            $success = Order::query()->where('user_id', Auth::id())->where('status', Order::PAY_STATUS_SUCCESS)->count();
            $failed = Order::query()->where('user_id', Auth::id())->where('status', Order::PAY_STATUS_FAILED)->count();
            $result['data'] = [
                'pending' => $pending,
                'processing' => $processing,
                'success' => $success,
                'failed' => $failed,
            ];
        }

        return $this->success($result);
    }

    /**
     * 我的首页 订单
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function orders(Request $request)
    {
        $type = $request->input('type');//1待支付 2进行中 3已完成 4已取消
        $orders = Order::query()
            ->with('items.house.layout')
            ->when($type, function ($query) use ($type) {
                switch ($type) {
                    case 1:
                        $status = Order::PAY_STATUS_PENDING;
                        break;
                    case 2:
                        $status = Order::PAY_STATUS_PROCESSING;
                        break;
                    case 3:
                        $status = Order::PAY_STATUS_SUCCESS;
                        break;
                    case 4:
                        $status = Order::PAY_STATUS_FAILED;
                        break;
                    default:
                        $status = null;
                }
                if ($status)
                    $query->where('status', $status);
            })
            ->get();
        return $this->success($orders);
    }

    /**
     * 我的房租
     */
    public function rentShow()
    {
        $rent = Auth::user()->house()
            ->with(['rentLog' => function ($query) {
                $query->whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'));
            }])
            ->first();
        $rent->electric_unit_price = config('electric_unit_price');
        $rent->cold_water_unit_price = config('cold_water_unit_price');
        $rent->hot_water_unit_price = config('hot_water_unit_price');
        return $this->success($rent);
    }

    /**
     * 交房租
     *
     * @param Request $request
     * @param WechatService $wechatService
     *
     * @throws \App\Exceptions\InvalidRequestException
     */
    public function rentStore(Request $request, WechatService $wechatService)
    {
        $this->checkPar($request, [
            'amount' => 'required',
            'id' => 'required',
        ]);
        $no = Order::findAvailableNo();
        $rent_log = RentLog::query()->find($request->input('id'));
        $rent_log->update(['no' => $no]);
        $open_id = $request->user()->open_id;

        $config = $wechatService->order($no, $request->input('amount'), '鑫南支付中心-房租支付', $open_id, route('api.pay.rent_pay_notify'));

        if (!$config) {//微信下单失败  删除原来订单 并把房子状态设置为可以出租
            $rent_log->update(['no' => $no]);
        }
        $config ? $this->success($config) : $this->error([], '微信支付签名验证失败');
    }

    /**
     * 公寓上传-本质就是上传户型
     *
     * @param Request $request
     *
     * @return array
     */
    public function uploadLayout(Request $request)
    {
        //$image = url('storage') . '/' . $request->file('image')->store('images/upload', 'public');
        //$request['image'] = $image;
        //$carousel = [];
        //foreach ($request->file('carousel') as $file) {
        //    $carousel[] = url('storage') . '/' . $file->store('images/upload', 'public');
        //}
        //$request['carousel'] = $carousel;
        $result = Layout::query()->create($request->only([
            'category_id',//公寓
            'property',//物业
            'name',//户型
            'rent',//租金
            'image',//封面图
            'carousel',//轮播图
            'description',//描述
            'recommend',//推荐
            'server_detail',//服务详情
        ]));
        return $this->success($result);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     * @throws \App\Exceptions\InvalidRequestException
     */
    public function getUsers(Request $request)
    {
        $this->checkPar($request, [
            'type' => 'required',
        ]);
        $result = User::query()->where('type', $request->input('type'))
            ->get();
        return $this->success($result);
    }

    /**
     * 用户管理的楼
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function categories(Request $request)
    {
        $user = $request->user();
        $result = $user->categories()->get();
        return $this->success($result);
    }


    public function tasks(Request $request, $id)
    {
        $user = User::query()->find($id);
        $result = $user->tasks()->get();
        return $this->success($result);
    }
}
