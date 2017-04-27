<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/26 0026
 * Time: 18:14
 */

namespace DingDing\Util;


use Curl\Curl;
use DingDing\Exceptions\DingDingException;

class Http
{

    /**
     * @var Curl
     */
    protected $curl;

    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }

    /**
     * Curl Get请求
     * @param $url
     * @param array $data
     * @return Curl
     * @throws DingDingException
     */
    public function get($url, $data = [])
    {
        $result = $this->curl->get($url, $data);
        if($result->error){
            throw new DingDingException($result->error_message, $result->error_code);
        }
    }

    /**
     * 钉钉post请求
     * @param $url
     * @param $data
     * @return mixed
     * @throws DingDingException
     */
    public function post($url, $data)
    {
        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        $result = curl_exec($ch);

        if(!$result){
            throw new DingDingException('钉钉消息发送失败');
        }

        return $result;
    }

    /**
     * 连接参数
     * @param $path
     * @param array $params
     * @return string
     */
    public static function joinPath($path, $params = [])
    {
        $path =  config('dingding.oapi_host').$path;

        if(!!count($params)){
            $path = $path .'?'.http_build_query($params);
        }

        return $path;
    }
}