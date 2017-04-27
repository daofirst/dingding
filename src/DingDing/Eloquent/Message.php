<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/26 0026
 * Time: 14:18
 */

namespace DingDing\Eloquent;

use DingDing\Contracts\MessageContract;
use DingDing\Exceptions\DingDingException;
use DingDing\Util\Http;

class Message implements MessageContract
{

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var Http
     */
    protected $http;

    public function __construct(Auth $auth, Http $http)
    {
        $this->auth = $auth;
        $this->http = $http;
    }

    /**
     * 企业发送消息
     * @param $opt
     * @return mixed
     * @throws DingDingException
     */
    public function send($opt)
    {
        try{
            $accessToken = $this->auth->getAccessToken();

            $data = array_replace($this->defaults(), $opt);

            $response = $this->http->post(Http::joinPath('/message/send', ['access_token' => $accessToken]), $data);

            return $response['messageId'];

        }catch (DingDingException $e){
            throw $e;
        }

    }

    /**
     * 获取默认消息体
     * @return array
     */
    public function defaults()
    {
        $data = [
            "msgtype" => 'oa',
            'agentid' => '92214217',
            'link' => [
                'messageUrl' => '',
                'picUrl' => '@lALOACZwe2Rk',
                'title' => '修店宝3.0系统消息',
                'text' => '你有一个新的系统消息，请点击查看！'
            ],
            'text' => [
                'content' => '你有一个修店宝3.0系统消息'
            ],
            'oa' => [
                'message_url' => '',
                'head' => [
                    'bgcolor' => 'CC438EB9',
                    'text' => '修店宝'
                ],
                'body' => [
                    'title' => '你有一个修店宝3.0系统消息',
                    'form' => [
                        ['key' => '消息码　：', 'value' => 'DD'.time()],
                    ],
                    'author' => '修店宝3.0系统　',
                    'content' => ''
                ],
            ],
        ];

        return $data;
    }
}