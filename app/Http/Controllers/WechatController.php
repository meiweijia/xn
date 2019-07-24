<?php

namespace App\Http\Controllers;

use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Http\Request;
use Overtrue\LaravelWeChat\Facade as EasyWechat;

class WechatController extends Controller
{
    /**
     * 微信服务启动
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\BadRequestException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \ReflectionException
     */
    public function serve()
    {
        $app = EasyWechat::officialAccount();
        $app->server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    switch ($message['Event']) {
                        case 'subscribe':
                            return new Text('欢迎关注鑫南服务！');
                            break;
                    }
            }
        });

        $response = $app->server->serve();

        return $response;
    }
}
