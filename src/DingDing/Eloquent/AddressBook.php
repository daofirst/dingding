<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/27 0027
 * Time: 10:38
 */

namespace DingDing\Eloquent;


use DingDing\Contracts\AddressBookInterface;
use DingDing\Util\Http;

class AddressBook implements AddressBookInterface
{

    /**
     * @var Http
     */
    protected $http;

    /**
     * @var Auth
     */
    protected $auth;

    public function __construct(Http $http, Auth $auth)
    {
        $this->http = $http;
        $this->auth = $auth;
    }

    /**
     * 获取部门列表
     * @param string $lang
     * @return mixed
     */
    public function getBranchList($lang = 'zh_CN')
    {
        return $this->http->get(Http::joinPath('/department/list',
            ['access_token' => $this->auth->getAccessToken(), 'lang' => $lang]));
    }

    /**
     * 获取部门详情
     * @param $id
     * @param string $lang
     * @return mixed
     */
    public function getBranch($id, $lang = 'zh_CN')
    {
        return $this->http->get(Http::joinPath('/department/get',
            ['access_token' => $this->auth->getAccessToken(), 'id' => $id, 'lang' => $lang]));
    }

    /**
     * 获取部门成员列表
     * @param $branchId
     * @param string $order
     * @param string $size
     * @param string $offset
     * @param string $lang
     * @return mixed
     */
    public function getUserList($branchId, $order = 'entry_asc', $size = '', $offset = '', $lang = 'zh_CN')
    {

        return $this->http->get(Http::joinPath('/user/simplelist',
            ['access_token' => $this->auth->getAccessToken(), 'department_id' => $branchId, 'lang' => $lang]));
    }

    /**
     * 获取部门成员详情列表
     * @param $branchId
     * @param string $order
     * @param string $size
     * @param string $offset
     * @param string $lang
     * @return mixed
     */
    public function getUserDetailList($branchId, $order = 'entry_asc', $size = '', $offset = '', $lang = 'zh_CN')
    {
        return $this->http->get(Http::joinPath('/user/list',
            ['access_token' => $this->auth->getAccessToken(), 'department_id' => $branchId, 'lang' => $lang]));
    }

    /**
     * 根据企业userid获取成员详细信息
     * @param $userId
     * @param string $lang
     * @return mixed
     */
    public function getUser($userId, $lang = 'zh_CN')
    {
        // TODO: Implement getUser() method.
    }
}
