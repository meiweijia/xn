<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Overtrue\LaravelWeChat\Facade as EasyWechat;

class WechatService
{
    /**
     * 下单
     *
     * @param string $trade_no
     * @param int $total_fee
     * @param string $body
     * @param string $openid
     * @param string $notify_url
     *
     * @return mixed
     * @throws
     */
    public function order($trade_no, $total_fee, $body, $openid, $notify_url)
    {
        if (!app()->environment('production')) {//如果不是生产环境，微信的沙箱环境 支付金额必须位 101 和 102 也就是 1.01 元和 1.02 元
            $total_fee = 101;
        }
        $app = EasyWechat::payment();
        $par = [
            'body' => $body,
            'out_trade_no' => $trade_no,
            'total_fee' => $total_fee,
            'trade_type' => 'JSAPI',
            'openid' => $openid,
            'notify_url' => $notify_url
        ];
        Log::info('下单参数', $par);

        $result = $app->order->unify($par);

        Log::info('下单', $result);

        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $result = $app->jssdk->appConfig($result['prepay_id']);//第二次签名
            $config = $app->jssdk->sdkConfig($result['prepayid']);
            return $config;
        } else {
            return false;
        }
    }

    /**
     * 获取小程序用户的 openId
     *
     * @param $code
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function openid($code)
    {
        $app = EasyWechat::miniProgram();
        $result = $app->auth->session($code);
        if (array_key_exists('errcode', $result)) {
            return false;
        }
        return $result['openid'];
    }
}
