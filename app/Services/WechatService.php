<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Overtrue\LaravelWeChat\Facade as EasyWechat;

class WechatService
{
    /**
     * 下单
     *
     * @param $trade_no
     * @param $total_fee
     * @param $body
     *
     * @return mixed
     */
    public function order($trade_no, $total_fee, $body, $openid, $notify_url)
    {
        $app = EasyWechat::payment();
        $par = [
            'body' => $body,
            'out_trade_no' => $trade_no,
            'total_fee' => $total_fee,
            'trade_type' => 'JSAPI',
            'openid' => $openid,
            'notify_url' => $notify_url
        ];

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
}
