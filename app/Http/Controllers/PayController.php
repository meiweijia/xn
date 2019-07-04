<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Overtrue\LaravelWeChat\Facade as EasyWechat;

class PayController extends ApiController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\Exception
     */
    public function wechatPayNotify()
    {
        $app = EasyWechat::payment();

        $response = $app->handlePaidNotify(function ($message, $fail) use ($app) {
            Log::info('wechatPayNotify', $message);
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = Order::query()->where('no', $message['out_trade_no'])->first();

            if (!$order || $order->paid_at) { // 如果订单不存在 或者 订单已经支付过了
                return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }

            ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            /// TODO 这里还没写完呢
            $wechatOrder = $app->order->queryByTransactionId($message['transaction_id']);

            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (Arr::get($message, 'result_code') === 'SUCCESS') {

                    if ($order->status == Order::PAY_STATUS_PENDING) {//订单状态为未支付时，才进这里的逻辑
                        //更新订单数据
                        $order->paid_at = time(); // 更新支付时间为当前时间
                        $order->status = Order::PAY_STATUS_PROCESSING;//订单设置为处理中
                        $order->payment_no = $message['transaction_id'];
                        $order->payment_method = 'wechat';
                    }
                } elseif (Arr::get($message, 'result_code') === 'FAIL') {// 用户支付失败
                    $order->status = Order::PAY_STATUS_FAILED;

                    //TODO 更改房间为可租状态
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }

            $order->save(); // 保存订单

            return true; // 返回处理完成
        });
        return $response;
    }
}
