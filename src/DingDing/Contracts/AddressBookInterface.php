<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/27 0027
 * Time: 10:27
 */

namespace DingDing\Contracts;

/**
 * 钉钉通讯录接口
 * Interface AddressBookInterface
 * @package DingDing\Contracts
 */
interface AddressBookInterface
{
    /**
     * 获取部门列表
     * @param string $lang
     * @return mixed
     */
    public function getBranchList($lang = 'zh_CN');

    /**
     * 获取部门详情
     * @param $id
     * @param string $lang
     * @return mixed
     */
    public function getBranch($id, $lang = 'zh_CN');

    /**
     * 获取部门成员列表
     * @param $branchId
     * @param string $order
     * @param string $size
     * @param string $offset
     * @param string $lang
     * @return mixed
     */
    public function getUserList($branchId, $order = 'entry_asc', $size = '', $offset = '', $lang = 'zh_CN');

    /**
     * 获取部门成员详情列表
     * @param $branchId
     * @param string $order
     * @param string $size
     * @param string $offset
     * @param string $lang
     * @return mixed
     */
    public function getUserDetailList($branchId, $order = 'entry_asc', $size = '', $offset = '', $lang = 'zh_CN');

    /**
     * 根据企业userid获取成员详细信息
     * @param $userId
     * @param string $lang
     * @return mixed
     */
    public function getUser($userId, $lang = 'zh_CN');
}