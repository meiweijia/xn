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
            return $result;
        }
    }

    /**
     * @param $code
     * @param $iv
     * @param $encryptedData
     *
     * @return mixed
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function userInfo($code, $iv, $encryptedData)
    {
        $app = EasyWechat::miniProgram();
        $info = self::authInfo($code);
        if (!$info) {
            return false;
        }
        $session = $info['session_key'];
        $decryptedData = $app->encryptor->decryptData($session, $iv, $encryptedData);
        Log::info('wechat_auth_decrypted_data', $decryptedData);
        return $decryptedData;
    }

    /**
     * @param $code
     *
     * @return array|bool|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function authInfo($code)
    {
        $app = EasyWechat::miniProgram();
        $result = $app->auth->session($code);
        if (array_key_exists('errcode', $result)) {
            return false;
        }
        return $result;
    }
}
