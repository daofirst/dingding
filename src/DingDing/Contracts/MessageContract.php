<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/26 0026
 * Time: 13:45
 */

namespace DingDing\Contracts;


interface MessageContract
{
    /**
     * 企业发送消息
     * @param $opt
     * @return mixed
     */
    public function send($opt);
}